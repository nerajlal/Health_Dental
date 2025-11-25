<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\BulkOrder;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $distributor = auth()->user();

        // Get ALL order items for this distributor (no date filter)
        $orderItems = OrderItem::whereHas('product', function($query) use ($distributor) {
            $query->where('distributor_id', $distributor->id);
        })
        ->whereHas('order', function($query) {
            // Only exclude pending orders
            $query->where('status', '!=', 'pending');
        })
        ->with(['product', 'order'])
        ->get();

        // Calculate total revenue
        $totalRevenue = $orderItems->sum(function($item) {
            return $item->quantity * $item->product->base_price;
        });

        // Count unique orders
        $totalOrders = $orderItems->pluck('order_id')->unique()->count();

        // Count PENDING orders (orders waiting for admin approval that contain this distributor's products)
        $pendingOrdersCount = Order::where('status', 'pending')
            ->whereHas('items.product', function($query) use ($distributor) {
                $query->where('distributor_id', $distributor->id);
            })
            ->count();

        // Stats
        $stats = [
            'total_products' => Product::where('distributor_id', $distributor->id)->count(),
            
            'active_products' => Product::where('distributor_id', $distributor->id)
                ->where('is_active', true)
                ->where('status', 'approved')
                ->count(),
            
            'pending_orders' => $pendingOrdersCount,
            
            'total_revenue' => $totalRevenue,
        ];

        // Recent products
        $recentProducts = Product::where('distributor_id', $distributor->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Top selling products (ALL TIME)
        $topProducts = Product::where('distributor_id', $distributor->id)
            ->withSum(['orderItems' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->where('status', '!=', 'pending');
                });
            }], 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->take(5)
            ->get();

        // Recent bulk orders
        $recentBulkOrders = BulkOrder::where('distributor_id', $distributor->id)
            ->where('status', '!=', 'pending')
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('distributor.dashboard', compact(
            'stats',
            'orderItems',
            'recentProducts',
            'topProducts',
            'recentBulkOrders'
        ));
    }
}