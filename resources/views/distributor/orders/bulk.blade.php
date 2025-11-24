@extends('layouts.app')

@section('title', 'Bulk Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Bulk Orders</h1>
            <p class="mt-2 text-gray-600">Consolidated orders from admin for warehouse shipment</p>
        </div>
        <a href="{{ route('distributor.orders.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-list mr-2"></i>View Individual Orders
        </a>
    </div>

    <!-- Info Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-blue-900">About Bulk Orders</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Bulk orders are created when the admin approves multiple clinic orders. You need to ship all products to the admin warehouse, and the admin will then distribute them to individual clinics.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Orders List -->
    <div class="space-y-6">
        @forelse($bulkOrders as $bulkOrder)
        @php
            // Calculate distributor's total earnings for this bulk order
            $distributorEarnings = $bulkOrder->items->sum(function($item) {
                return $item->total_quantity * $item->product->base_price;
            });
        @endphp
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">
                    <div class="mb-4 sm:mb-0">
                        <h3 class="text-xl font-semibold text-gray-900">Bulk Order #{{ $bulkOrder->id }}</h3>
                        <p class="text-sm text-gray-500">Created on {{ $bulkOrder->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="text-left sm:text-right w-full sm:w-auto">
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                            @if($bulkOrder->status == 'delivered') bg-green-100 text-green-800
                            @elseif($bulkOrder->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($bulkOrder->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($bulkOrder->status == 'shipped') bg-indigo-100 text-indigo-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($bulkOrder->status) }}
                        </span>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Your Earnings</p>
                            <p class="text-2xl font-bold text-green-600">₹{{ number_format($distributorEarnings, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Products Summary -->
                <div class="border-t border-gray-200 pt-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Products to Ship:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($bulkOrder->items as $item)
                        @php
                            $itemEarning = $item->total_quantity * $item->product->base_price;
                        @endphp
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded object-cover">
                            @else
                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                <i class="fas fa-tooth text-gray-400"></i>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate" title="{{ $item->product->name }}">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->total_quantity }} × ₹{{ number_format($item->product->base_price, 2) }}</p>
                                <p class="text-sm font-semibold text-green-600">₹{{ number_format($itemEarning, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-gray-200 pt-4 mt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-box mr-2"></i>{{ $bulkOrder->items->count() }} different products • Total {{ $bulkOrder->items->sum('total_quantity') }} units
                    </div>
                    <a href="{{ route('distributor.orders.bulk-show', $bulkOrder) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View Full Details <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-boxes text-gray-300 text-6xl mb-4"></i>
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">No Bulk Orders Yet</h2>
            <p class="text-gray-600">Bulk orders will appear here when admin approves clinic orders</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $bulkOrders->links() }}
    </div>

    <!-- Summary Stats -->
    @if($bulkOrders->count() > 0)
    @php
        $totalEarnings = $bulkOrders->sum(function($bulkOrder) {
            return $bulkOrder->items->sum(function($item) {
                return $item->total_quantity * $item->product->base_price;
            });
        });
        $totalUnits = $bulkOrders->sum(function($bulkOrder) {
            return $bulkOrder->items->sum('total_quantity');
        });
    @endphp
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 font-medium">Total Bulk Orders</p>
                    <p class="text-3xl font-bold text-blue-900">{{ $bulkOrders->total() }}</p>
                </div>
                <i class="fas fa-boxes text-blue-300 text-4xl"></i>
            </div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 font-medium">Total Units to Ship</p>
                    <p class="text-3xl font-bold text-purple-900">{{ number_format($totalUnits) }}</p>
                </div>
                <i class="fas fa-box text-purple-300 text-4xl"></i>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 font-medium">Total Earnings (Page)</p>
                    <p class="text-3xl font-bold text-green-900">₹{{ number_format($totalEarnings, 2) }}</p>
                </div>
                <i class="fas fa-dollar-sign text-green-300 text-4xl"></i>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection