<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $distributor = auth()->user();
        
        // Date filter - DEFAULT to ALL TIME if not specified
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $productId = $request->product_id;

        // Build query
        $query = OrderItem::whereHas('product', function($q) use ($distributor) {
            $q->where('distributor_id', $distributor->id);
        })->whereHas('order', function($q) use ($startDate, $endDate) {
            $q->where('status', '!=', 'pending');
            
            // Only apply date filter if dates are provided
            if ($startDate && $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            }
        });

        // Apply product filter
        if ($productId) {
            $query->where('product_id', $productId);
        }

        $orderItems = $query->with(['product', 'order.clinic'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Calculate summary
        $summary = $this->calculateSummary($distributor, $startDate, $endDate, $productId);

        // Get products for filter
        $products = Product::where('distributor_id', $distributor->id)
            ->where('is_active', true)
            ->get();

        return view('distributor.analytics.index', compact(
            'orderItems',
            'summary',
            'products',
            'startDate',
            'endDate',
            'productId'
        ));
    }

    private function calculateSummary($distributor, $startDate, $endDate, $productId = null)
    {
        $query = OrderItem::whereHas('product', function($q) use ($distributor) {
            $q->where('distributor_id', $distributor->id);
        })->whereHas('order', function($q) use ($startDate, $endDate) {
            $q->where('status', '!=', 'pending');
            
            // Only apply date filter if dates are provided
            if ($startDate && $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            }
        });

        if ($productId) {
            $query->where('product_id', $productId);
        }

        $items = $query->with(['product', 'order'])->get();

        // Calculate earnings
        $totalEarnings = $items->sum(function($item) {
            return $item->quantity * $item->product->base_price;
        });

        $totalOrders = $items->pluck('order_id')->unique()->count();
        $totalProducts = $items->sum('quantity');
        $uniqueClinics = $items->pluck('order.clinic_id')->unique()->count();

        return [
            'total_earnings' => $totalEarnings,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
            'average_order_value' => $totalOrders > 0 ? $totalEarnings / $totalOrders : 0,
            'unique_clinics' => $uniqueClinics,
        ];
    }

    public function productAnalysis(Request $request)
    {
        $distributor = auth()->user();
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $productStats = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('COUNT(DISTINCT order_id) as order_count')
            )
            ->whereHas('product', function($q) use ($distributor) {
                $q->where('distributor_id', $distributor->id);
            })
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', '!=', 'pending');
                
                // Only apply date filter if provided
                if ($startDate && $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                }
            })
            ->with('product')
            ->groupBy('product_id')
            ->get();

        // Calculate earnings
        $productStats = $productStats->map(function($stat) {
            $stat->total_earnings = $stat->total_quantity * $stat->product->base_price;
            return $stat;
        })->sortByDesc('total_earnings');

        return view('distributor.analytics.product-analysis', compact('productStats', 'startDate', 'endDate'));
    }

    public function clinicAnalysis(Request $request)
    {
        $distributor = auth()->user();
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $clinicStats = OrderItem::select(
                'orders.clinic_id',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereHas('product', function($q) use ($distributor) {
                $q->where('distributor_id', $distributor->id);
            })
            ->where('orders.status', '!=', 'pending')
            ->when($startDate && $endDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('orders.created_at', [$startDate, $endDate]);
            })
            ->groupBy('orders.clinic_id')
            ->get();

        // Calculate earnings per clinic
        $clinicStats = $clinicStats->map(function($stat) use ($distributor, $startDate, $endDate) {
            $orderItem = OrderItem::whereHas('product', function($q) use ($distributor) {
                $q->where('distributor_id', $distributor->id);
            })->whereHas('order', function($q) use ($stat) {
                $q->where('clinic_id', $stat->clinic_id);
            })->with('order.clinic')->first();
            
            $stat->clinic = $orderItem->order->clinic ?? null;
            
            $items = OrderItem::whereHas('product', function($q) use ($distributor) {
                $q->where('distributor_id', $distributor->id);
            })->whereHas('order', function($q) use ($stat, $startDate, $endDate) {
                $q->where('clinic_id', $stat->clinic_id)
                  ->where('status', '!=', 'pending');
                  
                if ($startDate && $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                }
            })->with('product')->get();

            $stat->total_earnings = $items->sum(fn($item) => $item->quantity * $item->product->base_price);

            return $stat;
        })->filter(function($stat) {
            return $stat->clinic !== null;
        })->sortByDesc('total_earnings');

        return view('distributor.analytics.clinic-analysis', compact('clinicStats', 'startDate', 'endDate'));
    }
}