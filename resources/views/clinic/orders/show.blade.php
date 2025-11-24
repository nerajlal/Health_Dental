@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('clinic.orders.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Orders
        </a>
    </div>

    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                <p class="mt-2 text-gray-600">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <span class="px-4 py-2 text-lg font-semibold rounded-full 
                @if($order->status == 'delivered') bg-green-100 text-green-800
                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                @elseif($order->status == 'packed') bg-purple-100 text-purple-800
                @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    <!-- Order Status Timeline -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Status</h2>
        <div class="flex items-center justify-between">
            <div class="flex flex-col items-center {{ in_array($order->status, ['pending', 'processing', 'packed', 'shipped', 'delivered']) ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="w-12 h-12 rounded-full {{ in_array($order->status, ['pending', 'processing', 'packed', 'shipped', 'delivered']) ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                    <i class="fas fa-check"></i>
                </div>
                <p class="mt-2 text-sm font-medium">Pending</p>
            </div>
            <div class="flex-1 h-1 {{ in_array($order->status, ['processing', 'packed', 'shipped', 'delivered']) ? 'bg-blue-600' : 'bg-gray-300' }} mx-2"></div>
            <div class="flex flex-col items-center {{ in_array($order->status, ['processing', 'packed', 'shipped', 'delivered']) ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="w-12 h-12 rounded-full {{ in_array($order->status, ['processing', 'packed', 'shipped', 'delivered']) ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                    <i class="fas fa-cog"></i>
                </div>
                <p class="mt-2 text-sm font-medium">Processing</p>
            </div>
            <div class="flex-1 h-1 {{ in_array($order->status, ['packed', 'shipped', 'delivered']) ? 'bg-blue-600' : 'bg-gray-300' }} mx-2"></div>
            <div class="flex flex-col items-center {{ in_array($order->status, ['packed', 'shipped', 'delivered']) ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="w-12 h-12 rounded-full {{ in_array($order->status, ['packed', 'shipped', 'delivered']) ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                    <i class="fas fa-box"></i>
                </div>
                <p class="mt-2 text-sm font-medium">Packed</p>
            </div>
            <div class="flex-1 h-1 {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-blue-600' : 'bg-gray-300' }} mx-2"></div>
            <div class="flex flex-col items-center {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="w-12 h-12 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                    <i class="fas fa-truck"></i>
                </div>
                <p class="mt-2 text-sm font-medium">Shipped</p>
            </div>
            <div class="flex-1 h-1 {{ $order->status == 'delivered' ? 'bg-green-600' : 'bg-gray-300' }} mx-2"></div>
            <div class="flex flex-col items-center {{ $order->status == 'delivered' ? 'text-green-600' : 'text-gray-400' }}">
                <div class="w-12 h-12 rounded-full {{ $order->status == 'delivered' ? 'bg-green-600' : 'bg-gray-300' }} flex items-center justify-center text-white">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="mt-2 text-sm font-medium">Delivered</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Order Items</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
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
                                    <p class="text-sm text-gray-500">{{ $item->product->distributor->name }}</p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right w-full sm:w-auto pl-24 sm:pl-0">
                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-500">Price: ₹{{ number_format($item->price, 2) }}</p>
                                <p class="font-semibold text-gray-900">Total: ₹{{ number_format($item->quantity * $item->price, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-semibold text-gray-900">Order Total:</span>
                            <span class="text-3xl font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-medium text-gray-900">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Date:</span>
                        <span class="font-medium text-gray-900">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Time:</span>
                        <span class="font-medium text-gray-900">{{ $order->created_at->format('h:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Items:</span>
                        <span class="font-medium text-gray-900">{{ $order->items->count() }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-gray-900 font-semibold">Total Amount:</span>
                        <span class="font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            @if($order->status == 'pending')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-info-circle text-yellow-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-900">Order Pending</h3>
                        <p class="text-sm text-yellow-700 mt-1">Your order is awaiting admin approval. You'll be notified once it's processed.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection