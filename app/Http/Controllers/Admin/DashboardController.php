<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clinics' => User::where('role', 'clinic')->where('is_active', true)->count(),
            'total_distributors' => User::where('role', 'distributor')->where('is_active', true)->count(),
            'total_products' => Product::where('is_active', true)->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => OrderItem::whereHas('order', function($q) {
                $q->where('status', 'delivered');
            })->sum(\DB::raw('quantity * price')),
            'monthly_revenue' => OrderItem::whereHas('order', function($q) {
                $q->where('status', 'delivered')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'));
            })->sum(\DB::raw('quantity * price')),
        ];

        $recent_orders = Order::with(['clinic', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $pendingProductsCount = Product::where('status', 'pending')->count();

        $top_products = Product::with('distributor')
            ->withCount(['orderItems as total_sold' => function($query) {
                $query->select(DB::raw('sum(quantity)'));
            }])
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingProductsCount', 'recent_orders', 'top_products'));
    }

    public function analytics()
    {
        // Revenue analytics
        $monthly_revenue = OrderItem::whereHas('order', function($q) {
            $q->where('status', 'delivered')
              ->whereYear('created_at', date('Y'));
        })
        ->selectRaw('MONTH(created_at) as month, SUM(quantity * price) as revenue')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Product performance
        $product_performance = Product::withCount(['orderItems as total_quantity' => function($query) {
            $query->select(DB::raw('sum(quantity)'));
        }])
        ->withCount(['orderItems as total_revenue' => function($query) {
            $query->select(DB::raw('sum(quantity * price)'));
        }])
        ->orderBy('total_revenue', 'desc')
        ->get();

        // Clinic ordering patterns
        $clinic_orders = User::where('role', 'clinic')
            ->withCount('orders')
            ->withSum('orders as total_spent', DB::raw('(SELECT SUM(quantity * price) FROM order_items WHERE order_items.order_id = orders.id)'))
            ->orderBy('total_spent', 'desc')
            ->get();

        // Distributor performance
        $distributor_performance = User::where('role', 'distributor')
            ->withCount('products')
            ->with(['products' => function($query) {
                $query->withCount(['orderItems as total_orders' => function($q) {
                    $q->select(DB::raw('sum(quantity)'));
                }]);
            }])
            ->get();

        return view('admin.analytics', compact(
            'monthly_revenue',
            'product_performance',
            'clinic_orders',
            'distributor_performance'
        ));
    }
}