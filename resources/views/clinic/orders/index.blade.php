@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
            <p class="mt-2 text-gray-600">Track and manage your orders</p>
        </div>
        <a href="{{ route('clinic.products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-plus mr-2"></i>Create New Order
        </a>
    </div>

    <!-- Order Status Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center space-x-4 overflow-x-auto">
            <a href="{{ route('clinic.orders.index') }}" 
               class="px-4 py-2 rounded-lg font-medium {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All Orders
            </a>
            <a href="{{ route('clinic.orders.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg font-medium {{ request('status') == 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Pending
            </a>
            <a href="{{ route('clinic.orders.index', ['status' => 'processing']) }}" 
               class="px-4 py-2 rounded-lg font-medium {{ request('status') == 'processing' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Processing
            </a>
            <a href="{{ route('clinic.orders.index', ['status' => 'shipped']) }}" 
               class="px-4 py-2 rounded-lg font-medium {{ request('status') == 'shipped' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Shipped
            </a>
            <a href="{{ route('clinic.orders.index', ['status' => 'delivered']) }}" 
               class="px-4 py-2 rounded-lg font-medium {{ request('status') == 'delivered' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Delivered
            </a>
        </div>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                            @if($order->status == 'delivered') bg-green-100 text-green-800
                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'packed') bg-purple-100 text-purple-800
                            @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                        <p class="text-2xl font-bold text-gray-900 mt-2">${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>

                <!-- Order Items Preview -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($order->items->take(3) as $item)
                        <div class="flex items-center space-x-3">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded object-cover">
                            @else
                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                <i class="fas fa-tooth text-gray-400"></i>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($order->items->count() > 3)
                        <div class="flex items-center justify-center text-gray-500">
                            <span class="text-sm">+{{ $order->items->count() - 3 }} more items</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-gray-200 pt-4 mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-box mr-2"></i>{{ $order->items->count() }} items
                    </div>
                    <a href="{{ route('clinic.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View Details <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-shopping-bag text-gray-300 text-6xl mb-4"></i>
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">No Orders Yet</h2>
            <p class="text-gray-600 mb-6">Start shopping for dental supplies</p>
            <a href="{{ route('clinic.products.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                Browse Products
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection