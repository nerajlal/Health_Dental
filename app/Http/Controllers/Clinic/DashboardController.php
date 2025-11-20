<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $clinicId = Auth::id();

        $stats = [
            'total_orders' => Order::where('clinic_id', $clinicId)->count(),
            'pending_orders' => Order::where('clinic_id', $clinicId)->where('status', 'pending')->count(),
            'delivered_orders' => Order::where('clinic_id', $clinicId)->where('status', 'delivered')->count(),
            'total_spent' => Order::where('clinic_id', $clinicId)
                ->where('status', 'delivered')
                ->sum('total_amount'),
        ];

        $recentOrders = Order::where('clinic_id', $clinicId)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $topProducts = Product::whereHas('orderItems', function($query) use ($clinicId) {
            $query->whereHas('order', function($q) use ($clinicId) {
                $q->where('clinic_id', $clinicId);
            });
        })
        ->withCount(['orderItems as total_ordered' => function($query) use ($clinicId) {
            $query->select(DB::raw('sum(quantity)'))
                  ->whereHas('order', function($q) use ($clinicId) {
                      $q->where('clinic_id', $clinicId);
                  });
        }])
        ->orderBy('total_ordered', 'desc')
        ->take(5)
        ->get();

        return view('clinic.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}