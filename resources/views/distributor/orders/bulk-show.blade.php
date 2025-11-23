@extends('layouts.app')

@section('title', 'Bulk Order Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('distributor.orders.bulk') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Bulk Orders
        </a>
    </div>

    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Bulk Order #{{ $bulkOrder->id }}</h1>
                <p class="mt-2 text-gray-600">Created on {{ $bulkOrder->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <span class="px-4 py-2 text-lg font-semibold rounded-full 
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Products to Ship -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Products to Ship to Admin Warehouse</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($bulkOrder->items as $item)
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4 w-full sm:w-auto mb-4 sm:mb-0">
                                @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 rounded object-cover flex-shrink-0">
                                @else
                                <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-tooth text-gray-400 text-2xl"></i>
                                </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                    <p class="text-sm text-gray-500">Unit Price: ${{ number_format($item->product->base_price, 2) }}</p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right w-full sm:w-auto pl-24 sm:pl-0">
                                <p class="text-2xl font-bold text-gray-900">{{ $item->total_quantity }}</p>
                                <p class="text-sm text-gray-500">units</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">Total: ${{ number_format($item->total_quantity * $item->product->base_price, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-semibold text-gray-900">Bulk Order Total:</span>
                            <span class="text-3xl font-bold text-gray-900">${{ number_format($bulkOrder->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Breakdown by Clinic Orders -->
            <!-- <div class="bg-white rounded-lg shadow mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Breakdown by Clinic Orders</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($bulkOrder->clinic_orders as $order)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $order->clinic->name }}</p>
                                    <p class="text-sm text-gray-500">Order #{{ $order->id }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->items->count() }} items</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> -->
        </div>

        <!-- Shipping Information -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Details</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Ship To:</p>
                        <p class="font-medium text-gray-900">Admin Warehouse</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Products:</p>
                        <p class="font-medium text-gray-900">{{ $bulkOrder->items->count() }} different products</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Units:</p>
                        <p class="font-medium text-gray-900">{{ $bulkOrder->items->sum('total_quantity') }} units</p>
                    </div>
                    <!-- <div>
                        <p class="text-sm text-gray-500">Total Clinics:</p>
                        <p class="font-medium text-gray-900">{{ $bulkOrder->clinic_orders->count() }} clinics</p>
                    </div> -->
                    <div class="pt-3 border-t">
                        <p class="text-sm text-gray-500">Order Value:</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($bulkOrder->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            @if($bulkOrder->status != 'delivered')
            <!-- <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Update Status</h2>
                <form action="{{ route('distributor.orders.update-bulk-status', $bulkOrder) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ $bulkOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $bulkOrder->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $bulkOrder->status == 'shipped' ? 'selected' : '' }}>Shipped to Warehouse</option>
                            <option value="delivered" {{ $bulkOrder->status == 'delivered' ? 'selected' : '' }}>Delivered to Warehouse</option>
                        </select>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                            Update Status
                        </button>
                    </div>
                </form>
            </div> -->
            @endif

            <!-- <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-info-circle text-yellow-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-900">Important</h3>
                        <p class="text-sm text-yellow-700 mt-1">Ship all products to the admin warehouse. The admin will then repack and distribute to individual clinics.</p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection