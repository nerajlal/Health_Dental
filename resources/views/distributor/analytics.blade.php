@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Analytics Dashboard</h1>
        <p class="mt-2 text-gray-600">Your business performance and insights</p>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Revenue</p>
                    <p class="text-3xl font-bold mt-2">${{ number_format($metrics['total_revenue'] ?? 0, 2) }}</p>
                    <p class="text-blue-100 text-xs mt-1">This month</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Orders</p>
                    <p class="text-3xl font-bold mt-2">{{ $metrics['total_orders'] ?? 0 }}</p>
                    <p class="text-green-100 text-xs mt-1">All time</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Active Products</p>
                    <p class="text-3xl font-bold mt-2">{{ $metrics['active_products'] ?? 0 }}</p>
                    <p class="text-purple-100 text-xs mt-1">In catalog</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-box text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Total Clinics</p>
                    <p class="text-3xl font-bold mt-2">{{ $metrics['total_clinics'] ?? 0 }}</p>
                    <p class="text-orange-100 text-xs mt-1">Customers</p>
                </div>
                <div class="bg-orange-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-hospital text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Monthly Revenue</h2>
            <div class="h-64 flex items-end space-x-2">
                @foreach($monthly_revenue ?? [] as $month)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition cursor-pointer" 
                         style="height: {{ $monthly_revenue->max('revenue') > 0 ? ($month->revenue / $monthly_revenue->max('revenue')) * 100 : 0 }}%"
                         title="${{ number_format($month->revenue, 2) }}">
                    </div>
                    <span class="text-xs text-gray-600 mt-2">{{ date('M', mktime(0, 0, 0, $month->month, 1)) }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Top Selling Products</h2>
            <div class="space-y-3">
                @forelse($top_products ?? [] as $product)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded object-cover">
                        @else
                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                            <i class="fas fa-tooth text-gray-400"></i>
                        </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">{{ $product->total_sold ?? 0 }} units sold</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">${{ number_format($product->total_revenue ?? 0, 2) }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-4">No sales data yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Recent Orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clinic</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recent_orders ?? [] as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">#{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->clinic->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->items_count }} items</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status == 'delivered') bg-green-100 text-green-800
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800
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
</div>
@endsection