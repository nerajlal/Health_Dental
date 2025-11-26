@extends('layouts.app')

@section('title', 'Sales Analytics')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Sales Analytics</h1>
        <p class="mt-2 text-gray-600">Track your sales performance and earnings</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('distributor.analytics') }}" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Overview
            </a>
            <a href="{{ route('distributor.analytics.products') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Product Performance
            </a>
        </nav>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('distributor.analytics') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate ?? '' }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="All Time">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate ?? '' }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="All Time">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                <select name="product_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Products</option>
                    @foreach($products as $prod)
                    <option value="{{ $prod->id }}" {{ $productId == $prod->id ? 'selected' : '' }}>
                        {{ $prod->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                @if($startDate || $endDate || $productId)
                <a href="{{ route('distributor.analytics') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
        @if(!$startDate && !$endDate)
        <div class="mt-3 text-sm text-blue-600">
            <i class="fas fa-info-circle mr-1"></i>
            Showing all-time data. Use date filters to narrow results.
        </div>
        @endif
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Earnings</p>
                    <p class="text-2xl font-bold text-green-600">₹{{ number_format($summary['total_earnings'], 2) }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-indian-rupee-sign text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary['total_orders'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Products Sold</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($summary['total_products']) }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-box text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Clinics</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary['unique_clinics'] }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <i class="fas fa-clinic-medical text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600 mb-2">Average Earnings Per Order</p>
                <p class="text-3xl font-bold text-gray-900">₹{{ number_format($summary['average_order_value'], 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-2">Average Items Per Order</p>
                <p class="text-3xl font-bold text-gray-900">
                    {{ $summary['total_orders'] > 0 ? number_format($summary['total_products'] / $summary['total_orders'], 1) : 0 }}
                </p>
            </div>
        </div>
    </div>

    <!-- Transaction Details Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">All Sales Transactions</h2>
            <a href="{{ route('distributor.analytics.products') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View Product Analysis <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clinic</th> -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Shipment Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Your Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Earnings</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orderItems as $item)
                    @php
                        $earnings = $item->quantity * $item->product->base_price;
                    @endphp
                    <tr class="{{ $item->shipped_to_admin ? 'bg-green-50' : 'hover:bg-gray-50' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item->order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="text-blue-600 font-medium">#{{ $item->order->id }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                            <div class="text-gray-500 text-xs">SKU: {{ $item->product->sku }}</div>
                        </td>
                        <!-- <td class="px-6 py-4 text-sm text-gray-900">
                            <div>{{ $item->order->clinic->name }}</div>
                            <div class="text-xs text-gray-500">{{ $item->order->clinic->email }}</div>
                        </td> -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($item->shipped_to_admin)
                                <div class="flex flex-col">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mb-1">
                                        <i class="fas fa-check-circle mr-1"></i> Shipped to Admin
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $item->shipped_at->format('M d, Y') }}</span>
                                </div>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Pending Shipment
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                            ₹{{ number_format($item->product->base_price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                            ₹{{ number_format($earnings, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                            <p>No sales transactions found for the selected period.</p>
                            <p class="text-sm mt-2">Try adjusting your filters or date range.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($orderItems->count() > 0)
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-sm text-gray-900 text-right">TOTAL EARNINGS:</td>
                        <td class="px-6 py-4 text-sm text-right text-green-600">
                            ₹{{ number_format($orderItems->sum(fn($item) => $item->quantity * $item->product->base_price), 2) }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orderItems->appends(request()->query())->links() }}
    </div>

    <!-- Shipment Summary Stats -->
    @if($orderItems->count() > 0)
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 font-medium">Shipped to Admin</p>
                    <p class="text-2xl font-bold text-green-900">{{ $orderItems->where('shipped_to_admin', true)->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-green-300 text-3xl"></i>
            </div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600 font-medium">Pending Shipment</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $orderItems->where('shipped_to_admin', false)->count() }}</p>
                </div>
                <i class="fas fa-clock text-yellow-300 text-3xl"></i>
            </div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 font-medium">Total Items</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $orderItems->count() }}</p>
                </div>
                <i class="fas fa-box text-blue-300 text-3xl"></i>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection