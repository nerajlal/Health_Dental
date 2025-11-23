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
                        <p class="text-2xl font-bold text-gray-900 mt-2">${{ number_format($bulkOrder->total_amount, 2) }}</p>
                    </div>
                </div>

                <!-- Products Summary -->
                <div class="border-t border-gray-200 pt-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Products to Ship:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($bulkOrder->items as $item)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded object-cover">
                            @else
                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                <i class="fas fa-tooth text-gray-400"></i>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->total_quantity }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-gray-200 pt-4 mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-box mr-2"></i>{{ $bulkOrder->items->count() }} different products • Total {{ $bulkOrder->items->sum('total_quantity') }} units
                    </div>
                    <a href="{{ route('distributor.orders.bulk-show', $bulkOrder) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View Details <i class="fas fa-arrow-right ml-1"></i>
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
</div>
@endsection