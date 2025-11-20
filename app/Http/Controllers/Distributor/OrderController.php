<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $distributorId = Auth::id();
        
        // Only show order items from orders that are NOT pending (i.e., approved by admin)
        $query = OrderItem::whereHas('product', function($q) use ($distributorId) {
            $q->where('distributor_id', $distributorId);
        })
        ->whereHas('order', function($q) {
            // Exclude pending orders - only show after admin approval
            $q->where('status', '!=', 'pending');
        })
        ->with(['order.clinic', 'product']);

        // Filter by order status if provided
        if ($request->status) {
            $query->whereHas('order', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Filter by date if provided
        if ($request->date_from) {
            $query->whereHas('order', function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            });
        }

        $orderItems = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('distributor.orders.index', compact('orderItems'));
    }

    public function bulkOrders(Request $request)
    {
        $distributorId = Auth::id();
        
        // Only show bulk orders that have been created (status is not pending)
        $query = BulkOrder::where('distributor_id', $distributorId)
            ->where('status', '!=', 'pending') // Only approved bulk orders
            ->with(['items.product', 'clinic_orders.clinic']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $bulkOrders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('distributor.orders.bulk', compact('bulkOrders'));
    }

    public function showBulkOrder(BulkOrder $bulkOrder)
    {
        // Ensure distributor can only see their own bulk orders
        if ($bulkOrder->distributor_id !== Auth::id()) {
            abort(403);
        }

        // Get all order items for this distributor from orders created around the bulk order time
        $orderItems = OrderItem::whereHas('product', function($query) {
            $query->where('distributor_id', Auth::id());
        })
        ->whereHas('order', function($query) use ($bulkOrder) {
            $query->whereBetween('created_at', [
                $bulkOrder->created_at->subHours(1),
                $bulkOrder->created_at->addHours(1)
            ])
            ->where('status', '!=', 'cancelled');
        })
        ->with(['order.clinic', 'product'])
        ->get();

        return view('distributor.orders.bulk-show', compact('bulkOrder', 'orderItems'));
    }

    public function updateBulkOrderStatus(Request $request, BulkOrder $bulkOrder)
    {
        // Ensure distributor can only update their own bulk orders
        if ($bulkOrder->distributor_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered'
        ]);

        $bulkOrder->update($validated);

        return redirect()->back()
            ->with('success', 'Bulk order status updated successfully.');
    }

    public function approveAll(Request $request)
    {
        // Get all pending orders
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
            // Calculate total amount
            $totalAmount = 0;
            foreach ($data['items'] as $productId => $itemData) {
                $totalAmount += $itemData['product']->base_price * $itemData['total_quantity'];
            }

            // Create bulk order
            $bulkOrder = BulkOrder::create([
                'distributor_id' => $distributorId,
                'total_amount' => $totalAmount,
                'status' => 'processing', // Changed from pending to processing
            ]);

            // Create bulk order items
            foreach ($data['items'] as $productId => $itemData) {
                $bulkOrder->items()->create([
                    'product_id' => $productId,
                    'total_quantity' => $itemData['total_quantity'],
                ]);
            }
        }

        // Update all pending orders to processing
        Order::where('status', 'pending')->update([
            'status' => 'processing'
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'All pending orders approved successfully! Bulk orders created for distributors.');
    }

}