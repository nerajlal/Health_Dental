@extends('layouts.app')

@section('title', 'Distributor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="section-title text-4xl mb-2">Welcome, {{ auth()->user()->name }}</h1>
        <p class="text-lg text-gray-600">Manage your products and orders</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Products</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['total_products'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Active Products</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['active_products'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Pending Orders</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['pending_orders'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                ₹{{ number_format($orderItems->sum(function($item) {
                    return $item->quantity * $item->product->base_price;
                }), 2) }}
            </p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif;">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('distributor.products.create') }}" class="stat-card group cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Add New Product</p>
                        <p class="text-lg font-semibold text-gray-700">Expand your catalog</p>
                    </div>
                    <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus-circle text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                    <span>Create product</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
            
            <a href="{{ route('distributor.orders.bulk') }}" class="stat-card group cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">View Bulk Orders</p>
                        <p class="text-lg font-semibold text-gray-700">Manage deliveries</p>
                    </div>
                    <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-truck text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                    <span>View orders</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
            
            <a href="{{ route('distributor.analytics') }}" class="stat-card group cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">View Analytics</p>
                        <p class="text-lg font-semibold text-gray-700">Track performance</p>
                    </div>
                    <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                    <span>Open analytics</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recently Added Products -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Recently Added Products</h2>
                <a href="{{ route('distributor.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold flex items-center">
                    View All <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentProducts as $product)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100 hover:shadow-md transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">₹{{ number_format($product->base_price, 2) }}</p>
                            @if($product->status == 'pending')
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full font-semibold">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @elseif($product->status == 'approved' && $product->is_active)
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-semibold">
                                    <i class="fas fa-check-circle"></i> Active
                                </span>
                            @elseif($product->status == 'rejected')
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-semibold">
                                    <i class="fas fa-times-circle"></i> Rejected
                                </span>
                            @else
                                <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full font-semibold">
                                    <i class="fas fa-pause-circle"></i> Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-box-open text-4xl text-gray-300 mb-2"></i>
                        <p>No products yet. Add your first product!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Top Selling Products</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-trophy text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">₹{{ number_format($product->base_price, 2) }} per {{ $product->unit }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-green-600">{{ $product->order_items_sum_quantity ?? 0 }}</p>
                            <p class="text-xs text-gray-500">units sold</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-chart-bar text-4xl text-gray-300 mb-2"></i>
                        <p>No sales data available</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bulk Orders -->
    @if(isset($recentBulkOrders) && $recentBulkOrders->count() > 0)
    <div class="card mt-8">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Recent Bulk Orders</h2>
            <a href="{{ route('distributor.orders.bulk') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold flex items-center">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Your Earnings</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentBulkOrders as $bulkOrder)
                    @php
                        $distributorEarnings = $bulkOrder->items->sum(function($item) {
                            return $item->total_quantity * $item->product->base_price;
                        });
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                            #{{ $bulkOrder->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                            ₹{{ number_format($distributorEarnings, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($bulkOrder->status == 'delivered') bg-green-100 text-green-800
                                @elseif($bulkOrder->status == 'processing') bg-blue-100 text-blue-800
                                @elseif($bulkOrder->status == 'shipped') bg-indigo-100 text-indigo-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($bulkOrder->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $bulkOrder->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('distributor.orders.bulk-show', $bulkOrder) }}" 
                               class="text-blue-600 hover:text-blue-800 font-semibold">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
