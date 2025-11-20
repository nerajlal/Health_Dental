@extends('layouts.app')

@section('title', 'Distributor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}</h1>
        <p class="mt-2 text-gray-600">Manage your products and orders</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
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
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Active Products</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $stats['active_products'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Orders</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $stats['pending_bulk_orders'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <i class="fas fa-dollar-sign text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                        <dd class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_revenue'], 2) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('distributor.products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg shadow text-center transition">
                <i class="fas fa-plus-circle text-3xl mb-2"></i>
                <h3 class="text-lg font-semibold">Add New Product</h3>
            </a>
            <a href="{{ route('distributor.orders.bulk') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg shadow text-center transition">
                <i class="fas fa-truck text-3xl mb-2"></i>
                <h3 class="text-lg font-semibold">View Bulk Orders</h3>
            </a>
            <a href="{{ route('distributor.analytics') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg shadow text-center transition">
                <i class="fas fa-chart-line text-3xl mb-2"></i>
                <h3 class="text-lg font-semibold">View Analytics</h3>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Recently Added Products</h2>
                <a href="{{ route('distributor.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentProducts as $product)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                        </div>
                        <div class="text-right ml-4">
                            <p class="text-lg font-bold text-gray-900">${{ number_format($product->base_price, 2) }}</p>
                            @if($product->status == 'pending')
                                <span class="text-xs text-yellow-600">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @elseif($product->status == 'approved' && $product->is_active)
                                <span class="text-xs text-green-600">
                                    <i class="fas fa-check-circle"></i> Active
                                </span>
                            @elseif($product->status == 'rejected')
                                <span class="text-xs text-red-600">
                                    <i class="fas fa-times-circle"></i> Rejected
                                </span>
                            @else
                                <span class="text-xs text-gray-600">
                                    <i class="fas fa-pause-circle"></i> Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-4">No products yet. Add your first product!</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Top Selling Products</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">${{ number_format($product->base_price, 2) }} per {{ $product->unit }}</p>
                        </div>
                        <div class="text-right ml-4">
                            <p class="text-lg font-bold text-green-600">{{ $product->order_items_sum_quantity ?? 0 }}</p>
                            <p class="text-xs text-gray-500">units sold</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-4">No sales data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bulk Orders -->
    @if(isset($recentBulkOrders) && $recentBulkOrders->count() > 0)
    <!-- <div class="bg-white rounded-lg shadow mt-8">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Recent Bulk Orders</h2>
            <a href="{{ route('distributor.orders.bulk') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentBulkOrders as $bulkOrder)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                            #{{ $bulkOrder->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($bulkOrder->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($bulkOrder->status == 'delivered') bg-green-100 text-green-800
                                @elseif($bulkOrder->status == 'processing') bg-blue-100 text-blue-800
                                @elseif($bulkOrder->status == 'shipped') bg-indigo-100 text-indigo-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($bulkOrder->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $bulkOrder->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('distributor.orders.bulk-show', $bulkOrder) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> -->
    @endif
</div>
@endsection