<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\BulkOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // 1. PENDING CLINIC ORDERS (Need approval)
        $pendingOrders = Order::with(['clinic', 'items.product.distributor'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. ORDERS IN PROGRESS (Distributors are processing)
        $processingOrdersQuery = Order::with(['clinic', 'items' => function($query) {
            $query->with('product.distributor');
        }])
        ->whereIn('status', ['processing', 'packed']);

        if ($request->status_filter) {
            $processingOrdersQuery->where('status', $request->status_filter);
        }

        $processingOrders = $processingOrdersQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'processing_page');

        // 3. SHIPPED ORDERS (Ready to mark as delivered)
        $shippedOrders = Order::with(['clinic', 'items.product.distributor'])
            ->where('status', 'shipped')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'shipped_page');

        // Count items shipped by distributors for each order
        foreach ($processingOrders as $order) {
            $order->shipped_items_count = $order->items->where('shipped_to_admin', true)->count();
            $order->total_items_count = $order->items->count();
        }

        return view('admin.orders.index', compact('pendingOrders', 'processingOrders', 'shippedOrders'));
    }

    public function show(Order $order)
    {
        $order->load(['clinic', 'items.product.distributor']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function pending()
    {
        $pendingOrders = Order::with(['clinic', 'items.product.distributor'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by distributor
        $groupedByDistributor = [];
        
        foreach ($pendingOrders as $order) {
            foreach ($order->items as $item) {
                $distributorId = $item->product->distributor_id;
                $distributorName = $item->product->distributor->name;
                
                if (!isset($groupedByDistributor[$distributorId])) {
                    $groupedByDistributor[$distributorId] = [
                        'distributor' => $item->product->distributor,
                        'items' => [],
                    ];
                }
                
                $groupedByDistributor[$distributorId]['items'][] = [
                    'order' => $order,
                    'item' => $item,
                ];
            }
        }

        return view('admin.orders.pending', compact('pendingOrders', 'groupedByDistributor'));
    }

    public function approveAll(Request $request)
    {
        $pendingOrders = Order::where('status', 'pending')->get();
        
        if ($pendingOrders->isEmpty()) {
            return redirect()->back()->with('info', 'No pending orders to approve');
        }

        // Group order items by distributor
        $distributorOrders = [];
        
        foreach ($pendingOrders as $order) {
            foreach ($order->items as $item) {
                $distributorId = $item->product->distributor_id;
                
                if (!isset($distributorOrders[$distributorId])) {
                    $distributorOrders[$distributorId] = [
                        'orders' => [],
                        'items' => [],
                    ];
                }
                
                $distributorOrders[$distributorId]['orders'][] = $order->id;
                
                if (!isset($distributorOrders[$distributorId]['items'][$item->product_id])) {
                    $distributorOrders[$distributorId]['items'][$item->product_id] = [
                        'product' => $item->product,
                        'total_quantity' => 0,
                    ];
                }
                
                $distributorOrders[$distributorId]['items'][$item->product_id]['total_quantity'] += $item->quantity;
            }
        }

        // Create bulk orders for each distributor
        foreach ($distributorOrders as $distributorId => $data) {
            $totalAmount = 0;
            foreach ($data['items'] as $productId => $itemData) {
                $totalAmount += $itemData['product']->base_price * $itemData['total_quantity'];
            }

            $bulkOrder = BulkOrder::create([
                'distributor_id' => $distributorId,
                'total_amount' => $totalAmount,
                'status' => 'processing',
            ]);

            foreach ($data['items'] as $productId => $itemData) {
                $bulkOrder->items()->create([
                    'product_id' => $productId,
                    'total_quantity' => $itemData['total_quantity'],
                ]);
            }
        }

        // Update all pending orders to processing
        Order::where('status', 'pending')->update(['status' => 'processing']);

        return redirect()->route('admin.orders.index')
            ->with('success', 'All pending orders approved! Bulk orders created for distributors.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,packed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}