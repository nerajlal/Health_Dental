<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\BulkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['clinic', 'items.product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('clinic')) {
            $query->where('clinic_id', $request->clinic);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['clinic', 'items.product.distributor']);
        return view('admin.orders.show', compact('order'));
    }

    public function pending()
    {
        $pendingOrders = Order::where('status', 'pending')
            ->with(['clinic', 'items.product.distributor'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Group items by distributor
        $groupedByDistributor = [];
        foreach ($pendingOrders as $order) {
            foreach ($order->items as $item) {
                $distributorId = $item->product->distributor_id;
                if (!isset($groupedByDistributor[$distributorId])) {
                    $groupedByDistributor[$distributorId] = [
                        'distributor' => $item->product->distributor,
                        'items' => []
                    ];
                }
                $groupedByDistributor[$distributorId]['items'][] = [
                    'order' => $order,
                    'item' => $item
                ];
            }
        }

        return view('admin.orders.pending', compact('pendingOrders', 'groupedByDistributor'));
    }

    public function approveAll(Request $request)
    {
        DB::beginTransaction();
        try {
            $pendingOrders = Order::where('status', 'pending')->get();

            // Group orders by distributor
            $bulkOrders = [];
            foreach ($pendingOrders as $order) {
                foreach ($order->items as $item) {
                    $distributorId = $item->product->distributor_id;
                    
                    if (!isset($bulkOrders[$distributorId])) {
                        $bulkOrder = BulkOrder::create([
                            'distributor_id' => $distributorId,
                            'status' => 'pending',
                            'total_amount' => 0
                        ]);
                        $bulkOrders[$distributorId] = $bulkOrder;
                    }

                    // Add to bulk order total
                    $bulkOrders[$distributorId]->total_amount += ($item->quantity * $item->price);
                    $bulkOrders[$distributorId]->save();
                }

                // Update order status
                $order->update(['status' => 'processing']);
            }

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'All pending orders approved and bulk orders created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to approve orders: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,packed,shipped,delivered,cancelled'
        ]);

        $order->update($validated);

        return redirect()->back()
            ->with('success', 'Order status updated successfully.');
    }
}