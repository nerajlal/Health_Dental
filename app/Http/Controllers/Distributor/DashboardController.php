<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\BulkOrder;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $distributorId = Auth::id();

        $stats = [
            'total_products' => Product::where('distributor_id', $distributorId)->count(),
            'active_products' => Product::where('distributor_id', $distributorId)
                ->where('is_active', true)
                ->where('status', 'approved')
                ->count(),
            'pending_bulk_orders' => BulkOrder::where('distributor_id', $distributorId)
                ->where('status', 'processing') // Not pending
                ->count(),
            'total_revenue' => OrderItem::whereHas('product', function($q) use ($distributorId) {
                $q->where('distributor_id', $distributorId);
            })->whereHas('order', function($q) {
                $q->where('status', 'delivered');
            })->sum(\DB::raw('quantity * order_items.price')),
        ];

        $recentProducts = Product::where('distributor_id', $distributorId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $topProducts = Product::where('distributor_id', $distributorId)
            ->withSum('orderItems', 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->limit(5)
            ->get();

        $recentBulkOrders = BulkOrder::where('distributor_id', $distributorId)
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('distributor.dashboard', compact('stats', 'recentProducts', 'topProducts', 'recentBulkOrders'));
    }

    public function analytics()
    {
        $distributorId = Auth::id();

        // Monthly revenue
        $monthlyRevenue = Product::where('distributor_id', $distributorId)
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->whereYear('orders.created_at', date('Y'))
            ->selectRaw('MONTH(orders.created_at) as month, SUM(order_items.quantity * products.base_price) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Product performance
        $productPerformance = Product::where('distributor_id', $distributorId)
            ->withCount(['orderItems as total_quantity' => function($query) {
                $query->select(DB::raw('sum(quantity)'));
            }])
            ->get();

        return view('distributor.analytics', compact('monthlyRevenue', 'productPerformance'));
    }
}