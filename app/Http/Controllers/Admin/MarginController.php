<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarginController extends Controller
{
    public function index(Request $request)
    {
        // Date filter
        $startDate = $request->start_date ?? now()->subMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $distributorId = $request->distributor_id;
        $productId = $request->product_id;

        // Build query for order items with delivered orders only
        $query = OrderItem::with(['product.distributor', 'order.clinic'])
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            });

        // Apply filters
        if ($distributorId) {
            $query->whereHas('product', function($q) use ($distributorId) {
                $q->where('distributor_id', $distributorId);
            });
        }

        if ($productId) {
            $query->where('product_id', $productId);
        }

        $orderItems = $query->orderBy('created_at', 'desc')->paginate(50);

        // Calculate summary statistics
        $summary = $this->calculateSummary($startDate, $endDate, $distributorId, $productId);

        // Get distributors and products for filters
        $distributors = User::where('role', 'distributor')->where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();

        return view('admin.margins.index', compact(
            'orderItems',
            'summary',
            'distributors',
            'products',
            'startDate',
            'endDate',
            'distributorId',
            'productId'
        ));
    }

    private function calculateSummary($startDate, $endDate, $distributorId = null, $productId = null)
    {
        $query = OrderItem::whereHas('order', function($q) use ($startDate, $endDate) {
            $q->where('status', 'delivered')
              ->whereBetween('created_at', [$startDate, $endDate]);
        });

        if ($distributorId) {
            $query->whereHas('product', function($q) use ($distributorId) {
                $q->where('distributor_id', $distributorId);
            });
        }

        if ($productId) {
            $query->where('product_id', $productId);
        }

        $items = $query->with('product')->get();

        $totalRevenue = $items->sum(function($item) {
            return $item->quantity * $item->price;
        });

        $totalCost = $items->sum(function($item) {
            return $item->quantity * $item->product->base_price;
        });

        $totalProfit = $totalRevenue - $totalCost;
        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;
        $totalOrders = $items->pluck('order_id')->unique()->count();
        $totalProducts = $items->sum('quantity');

        return [
            'total_revenue' => $totalRevenue,
            'total_cost' => $totalCost,
            'total_profit' => $totalProfit,
            'profit_margin' => $profitMargin,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
            'average_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
        ];
    }

    public function productAnalysis(Request $request)
    {
        $startDate = $request->start_date ?? now()->subMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        // Get product-wise profit analysis
        $productStats = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(quantity * price) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_id) as order_count')
            )
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->with('product.distributor')
            ->groupBy('product_id')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Calculate cost and profit for each product
        $productStats = $productStats->map(function($stat) {
            $stat->total_cost = $stat->total_quantity * $stat->product->base_price;
            $stat->total_profit = $stat->total_revenue - $stat->total_cost;
            $stat->profit_margin = $stat->total_revenue > 0 
                ? ($stat->total_profit / $stat->total_revenue) * 100 
                : 0;
            $stat->admin_margin_total = $stat->total_quantity * $stat->product->admin_margin;
            return $stat;
        });

        $distributors = User::where('role', 'distributor')->where('is_active', true)->get();

        return view('admin.margins.product-analysis', compact('productStats', 'startDate', 'endDate', 'distributors'));
    }

    public function distributorAnalysis(Request $request)
    {
        $startDate = $request->start_date ?? now()->subMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        // Get distributor-wise analysis
        $distributorStats = User::where('role', 'distributor')
            ->where('is_active', true)
            ->withCount(['products' => function($q) use ($startDate, $endDate) {
                $q->whereHas('orderItems.order', function($query) use ($startDate, $endDate) {
                    $query->where('status', 'delivered')
                          ->whereBetween('created_at', [$startDate, $endDate]);
                });
            }])
            ->get()
            ->map(function($distributor) use ($startDate, $endDate) {
                $orderItems = OrderItem::whereHas('product', function($q) use ($distributor) {
                    $q->where('distributor_id', $distributor->id);
                })->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->where('status', 'delivered')
                      ->whereBetween('created_at', [$startDate, $endDate]);
                })->with('product')->get();

                $distributor->total_revenue = $orderItems->sum(fn($item) => $item->quantity * $item->price);
                $distributor->total_cost = $orderItems->sum(fn($item) => $item->quantity * $item->product->base_price);
                $distributor->total_profit = $distributor->total_revenue - $distributor->total_cost;
                $distributor->profit_margin = $distributor->total_revenue > 0 
                    ? ($distributor->total_profit / $distributor->total_revenue) * 100 
                    : 0;
                $distributor->total_orders = $orderItems->pluck('order_id')->unique()->count();
                $distributor->total_quantity = $orderItems->sum('quantity');

                return $distributor;
            })
            ->sortByDesc('total_revenue');

        return view('admin.margins.distributor-analysis', compact('distributorStats', 'startDate', 'endDate'));
    }
}