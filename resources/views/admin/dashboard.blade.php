@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="mt-2 text-gray-600">Overview of your dental supply system</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('admin.orders.pending') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-lg shadow text-center transition">
            <i class="fas fa-clock text-3xl mb-2"></i>
            <h3 class="text-lg font-semibold">Pending Orders</h3>
            <p class="text-2xl font-bold mt-2">{{ $stats['pending_orders'] }}</p>
        </a>
        
        <a href="{{ route('admin.products.pending') }}" class="bg-orange-500 hover:bg-orange-600 text-white p-6 rounded-lg shadow text-center transition">
            <i class="fas fa-box-open text-3xl mb-2"></i>
            <h3 class="text-lg font-semibold">Pending Products</h3>
            <p class="text-2xl font-bold mt-2">{{ $pendingProductsCount }}</p>
        </a>
        
        <a href="{{ route('admin.analytics') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg shadow text-center transition">
            <i class="fas fa-chart-line text-3xl mb-2"></i>
            <h3 class="text-lg font-semibold">View Analytics</h3>
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <i class="fas fa-clinic-medical text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Clinics</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $stats['total_clinics'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-truck text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Distributors</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $stats['total_distributors'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <i class="fas fa-box text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Products</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <i class="fas fa-shopping-cart text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Orders</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Total Revenue</h3>
            <p class="text-3xl font-bold text-green-600">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Monthly Revenue</h3>
            <p class="text-3xl font-bold text-blue-600">${{ number_format($stats['monthly_revenue'], 2) }}</p>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Recent Orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clinic</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recent_orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                            <a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->clinic->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->items->count() }} items</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status == 'delivered') bg-green-100 text-green-800
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No recent orders</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Top Selling Products</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($top_products as $product)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $product->distributor->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900">{{ $product->total_sold ?? 0 }} sold</p>
                        <p class="text-sm text-gray-500">${{ number_format($product->base_price, 2) }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500">No product data available</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection