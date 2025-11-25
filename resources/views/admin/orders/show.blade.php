@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                <p class="mt-2 text-gray-600">Order details and status tracking</p>
            </div>
            <span class="px-4 py-2 text-sm font-semibold rounded-full 
                @if($order->status == 'delivered') bg-green-100 text-green-800
                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                @elseif($order->status == 'packed') bg-purple-100 text-purple-800
                @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Order Items</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-gray-50 rounded-lg space-y-4 sm:space-y-0">
                            <div class="flex items-center space-x-4 w-full sm:w-auto">
                                @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 rounded object-cover flex-shrink-0">
                                @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-tooth text-gray-400 text-2xl"></i>
                                </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                    <p class="text-sm text-gray-500">Distributor: {{ $item->product->distributor->name }}</p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right w-full sm:w-auto pl-20 sm:pl-0">
                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-500">Price: ₹{{ number_format($item->price, 2) }}</p>
                                <p class="font-semibold text-gray-900">Total: ₹{{ number_format($item->quantity * $item->price, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Order Total:</span>
                            <span class="text-2xl font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Update Order Status</h2>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex items-end space-x-4">
                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">New Status</label>
                            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="packed" {{ $order->status == 'packed' ? 'selected' : '' }}>Packed</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Clinic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Clinic Information</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Clinic Name</p>
                        <p class="font-medium text-gray-900">{{ $order->clinic->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-900">{{ $order->clinic->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium text-gray-900">{{ $order->clinic->phone ?? 'N/A' }}</p>
                    </div>
                    @if($order->clinic->address)
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium text-gray-900">{{ $order->clinic->address }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-3">
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
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Orders
        </a>
    </div>
</div>
@endsection