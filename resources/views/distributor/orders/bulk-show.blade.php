@extends('layouts.app')

@section('title', 'Bulk Order #' . $bulkOrder->id)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('distributor.orders.bulk') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Back to Bulk Orders
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Bulk Order #{{ $bulkOrder->id }}</h1>
                <p class="mt-2 text-gray-600">Created on {{ $bulkOrder->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <span class="px-4 py-2 text-sm font-semibold rounded-full 
                @if($bulkOrder->status == 'delivered') bg-green-100 text-green-800
                @elseif($bulkOrder->status == 'pending') bg-yellow-100 text-yellow-800
                @elseif($bulkOrder->status == 'processing') bg-blue-100 text-blue-800
                @elseif($bulkOrder->status == 'shipped') bg-indigo-100 text-indigo-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($bulkOrder->status) }}
            </span>
        </div>
    </div>

    @php
        $totalEarnings = $bulkOrder->items->sum(function($item) {
            return $item->total_quantity * $item->product->base_price;
        });
    @endphp

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Total Products</p>
            <p class="text-3xl font-bold text-gray-900">{{ $bulkOrder->items->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Total Units</p>
            <p class="text-3xl font-bold text-blue-600">{{ $bulkOrder->items->sum('total_quantity') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Your Total Earnings</p>
            <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalEarnings, 2) }}</p>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Products to Ship</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Your Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Your Earnings</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bulkOrder->items as $item)
                    @php
                        $itemEarning = $item->total_quantity * $item->product->base_price;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded mr-3">
                                @else
                                <div class="w-12 h-12 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-tooth text-gray-400"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->product->category }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->product->sku }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            ₹{{ number_format($item->product->base_price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-gray-900">
                            {{ $item->total_quantity }}
                            <span class="text-xs text-gray-500 font-normal">{{ $item->product->unit }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                            ₹{{ number_format($itemEarning, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-sm text-gray-900 text-right">TOTAL:</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">
                            {{ $bulkOrder->items->sum('total_quantity') }} units
                        </td>
                        <td class="px-6 py-4 text-sm text-right text-green-600">
                            ₹{{ number_format($totalEarnings, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Shipping Address (if needed) -->
    @if($bulkOrder->shipping_address)
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Address</h2>
        <div class="text-gray-700">
            <p class="font-medium">{{ $bulkOrder->shipping_address['name'] ?? 'Admin Warehouse' }}</p>
            <p>{{ $bulkOrder->shipping_address['address'] ?? '' }}</p>
            <p>{{ $bulkOrder->shipping_address['city'] ?? '' }}, {{ $bulkOrder->shipping_address['state'] ?? '' }} {{ $bulkOrder->shipping_address['zip'] ?? '' }}</p>
            @if(isset($bulkOrder->shipping_address['phone']))
            <p class="mt-2">Phone: {{ $bulkOrder->shipping_address['phone'] }}</p>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection