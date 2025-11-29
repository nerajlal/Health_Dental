@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="section-title text-4xl mb-2">Admin Dashboard</h1>
        <p class="text-lg text-gray-600">Overview of your dental supply system</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('admin.orders.pending') }}" class="stat-card group cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending Orders</p>
                    <p class="text-3xl font-bold gradient-text" style="font-family: 'Playfair Display', serif;">{{ $stats['pending_orders'] }}</p>
                </div>
                <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                <span>View all pending</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </div>
        </a>
        
        <a href="{{ route('admin.products.pending') }}" class="stat-card group cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending Products</p>
                    <p class="text-3xl font-bold gradient-text" style="font-family: 'Playfair Display', serif;">{{ $pendingProductsCount }}</p>
                </div>
                <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-box-open text-white text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                <span>Review products</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </div>
        </a>
        
        <a href="{{ route('admin.analytics') }}" class="stat-card group cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Analytics</p>
                    <p class="text-xl font-semibold text-gray-700">View Reports</p>
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

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clinic-medical text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Clinics</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['total_clinics'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-truck text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Distributors</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['total_distributors'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Products</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['total_products'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-yellow-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Pending Orders</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['pending_orders'] }}</p>
        </div>
    </div>

    <!-- Revenue Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="card p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-2">Total Order Revenue</p>
                    <p class="text-3xl font-bold text-green-600" style="font-family: 'Playfair Display', serif;">₹{{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="card p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-2">Monthly Order Revenue</p>
                    <p class="text-3xl font-bold text-blue-600" style="font-family: 'Playfair Display', serif;">₹{{ number_format($stats['monthly_revenue'], 2) }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Recent Orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Clinic</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recent_orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">#{{ $order->id }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $order->clinic->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->items->count() }} items</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status == 'delivered') bg-green-100 text-green-800
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                            <p>No recent orders</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Top Selling Products</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($top_products as $product)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $product->distributor->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900">{{ $product->total_sold ?? 0 }} sold</p>
                        <p class="text-sm text-gray-600">₹{{ number_format($product->base_price, 2) }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-chart-bar text-4xl text-gray-300 mb-2"></i>
                    <p>No product data available</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection