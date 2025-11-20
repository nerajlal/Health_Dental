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
        
        // Get order items for this distributor's products
        $query = OrderItem::whereHas('product', function($q) use ($distributorId) {
            $q->where('distributor_id', $distributorId);
        })->with(['order.clinic', 'product']);

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

    public function bulkOrders()
    {
        $bulkOrders = BulkOrder::where('distributor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

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
}