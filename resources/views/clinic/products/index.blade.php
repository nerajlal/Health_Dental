@extends('layouts.app')

@section('title', 'Browse Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Browse Products</h1>
            <p class="mt-2 text-gray-600">Find dental supplies for your clinic</p>
        </div>
        <a href="{{ route('clinic.cart') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium relative">
            <i class="fas fa-shopping-cart mr-2"></i> Cart
            @php
                $cartCount = session()->get('cart', []);
                $totalItems = collect($cartCount)->sum(function($item) {
                    return is_array($item) ? $item['quantity'] : (int)$item;
                });
            @endphp
            @if($totalItems > 0)
            <!-- <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
                {{ $totalItems }}
            </span> -->
            @endif
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('clinic.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
            <div class="relative group">
                <a href="{{ route('clinic.products.show', $product) }}" class="block">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-lg">
                    @else
                    <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                        <i class="fas fa-tooth text-gray-400 text-4xl"></i>
                    </div>
                    @endif
                </a>

                <!-- Quick Add to Cart Button -->
                @if($product->stock_quantity > 0)
                <form action="{{ route('clinic.cart.add', $product) }}" method="POST" class="absolute top-3 right-3">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 shadow-lg transition transform hover:scale-110 opacity-0 group-hover:opacity-100"
                            title="Quick Add to Cart">
                        <i class="fas fa-cart-plus text-lg"></i>
                    </button>
                </form>
                @else
                <div class="absolute top-3 right-3 bg-red-500 text-white rounded-full px-3 py-2 text-xs font-semibold">
                    Out of Stock
                </div>
                @endif

                <!-- Stock Badge -->
                @if($product->stock_quantity > 0 && $product->stock_quantity <= 10)
                <div class="absolute top-3 left-3 bg-yellow-500 text-white rounded-full px-3 py-1 text-xs font-semibold">
                    Only {{ $product->stock_quantity }} left
                </div>
                @endif
            </div>

            <div class="p-4">
                <a href="{{ route('clinic.products.show', $product) }}">
                    <h3 class="font-semibold text-gray-900 text-lg mb-1 hover:text-blue-600 line-clamp-2">{{ $product->name }}</h3>
                </a>
                <p class="text-sm text-gray-500 mb-2">{{ $product->company ?? 'N/A' }}</p>
                
                @if($product->category)
                <span class="inline-block px-2 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded mb-3">
                    {{ $product->category }}
                </span>
                @endif

                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm text-gray-500">Price</p>
                        <p class="text-2xl font-bold text-gray-900">
                            ₹{{ number_format($product->display_price ?? ($product->base_price + $product->admin_margin), 2) }}
                        </p>
                        <p class="text-xs text-gray-500">per {{ $product->unit }}</p>
                    </div>
                    <div class="text-right">
                        @if($product->stock_quantity > 0)
                        <span class="text-xs text-green-600 font-medium">
                            <i class="fas fa-check-circle"></i> In Stock
                        </span>
                        <p class="text-xs text-gray-500 mt-1">{{ $product->stock_quantity }} available</p>
                        @else
                        <span class="text-xs text-red-600 font-medium">
                            <i class="fas fa-times-circle"></i> Out of Stock
                        </span>
                        @endif
                    </div>
                </div>

                <div class="text-sm text-gray-600 mb-3">
                    <i class="fas fa-building text-gray-400"></i>
                    {{ $product->distributor->name }}
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('clinic.products.show', $product) }}" 
                       class="text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition text-sm">
                        <i class="fas fa-eye mr-1"></i>Details
                    </a>
                    
                    @if($product->stock_quantity > 0)
                    <form action="{{ route('clinic.cart.add', $product) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition text-sm">
                            <i class="fas fa-cart-plus mr-1"></i>Add
                        </button>
                    </form>
                    @else
                    <button disabled 
                            class="w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-medium cursor-not-allowed text-sm">
                        <i class="fas fa-ban mr-1"></i>Unavailable
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">No Products Found</h2>
                <p class="text-gray-600">Try adjusting your search or filter criteria</p>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>

<!-- Success Toast (Optional) -->
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection