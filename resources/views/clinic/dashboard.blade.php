@extends('layouts.app')

@section('title', 'Clinic Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="section-title text-4xl mb-2">Welcome, {{ auth()->user()->name }}</h1>
        <p class="text-lg text-gray-600">Manage your dental supply orders</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Orders</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['total_orders'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Pending Orders</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['pending_orders'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Delivered</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['delivered_orders'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-indian-rupee-sign text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Spent</p>
            <p class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">₹{{ number_format($stats['total_spent'], 2) }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif;">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('clinic.products.index') }}" class="stat-card group cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Browse Products</p>
                        <p class="text-lg font-semibold text-gray-700">Find what you need</p>
                    </div>
                    <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                    <span>Start shopping</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
            
            <a href="{{ route('clinic.cart') }}" class="stat-card group cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">View Cart</p>
                        <p class="text-lg font-semibold text-gray-700">Review your items</p>
                    </div>
                    <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-shopping-cart text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                    <span>Go to cart</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
            
            <a href="{{ route('clinic.orders.index') }}" class="stat-card group cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">My Orders</p>
                        <p class="text-lg font-semibold text-gray-700">Track your orders</p>
                    </div>
                    <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-list text-white text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                    <span>View all orders</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card mb-8">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Recent Orders</h2>
            <a href="{{ route('clinic.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold flex items-center">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                            <a href="{{ route('clinic.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">#{{ $order->id }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->items->count() }} items</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status == 'delivered') bg-green-100 text-green-800
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-shopping-bag text-4xl text-gray-300 mb-2"></i>
                            <p>No orders yet. Start shopping!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Frequently Ordered Products -->
    @if($topProducts->count() > 0)
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Your Frequently Ordered Products</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($topProducts as $product)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition hover:border-blue-300">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-white"></i>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-semibold">{{ $product->total_ordered }}x ordered</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $product->distributor->name }}</p>
                    <a href="{{ route('clinic.products.show', $product) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold flex items-center">
                        Order Again <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection