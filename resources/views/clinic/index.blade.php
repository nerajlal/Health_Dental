@extends('layouts.app')

@section('title', 'Browse Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Browse Products</h1>
        <p class="mt-2 text-gray-600">Find the dental supplies you need</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('clinic.products.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search products..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" id="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($products as $product)
        <div class="bg-white rounded-lg shadow hover:shadow-xl transition">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                 class="w-full h-48 object-cover rounded-t-lg">
            @else
            <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                <i class="fas fa-tooth text-6xl text-gray-400"></i>
            </div>
            @endif
            
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                <p class="text-sm text-gray-500 mb-2">{{ $product->distributor->name }}</p>
                
                @if($product->category)
                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mb-3">
                    {{ $product->category }}
                </span>
                @endif
                
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                
                <div class="flex items-center justify-between mb-4">
                    <span class="text-2xl font-bold text-green-600">${{ number_format($product->display_price, 2) }}</span>
                    <span class="text-sm text-gray-500">per {{ $product->unit }}</span>
                </div>
                
                <form action="{{ route('clinic.cart.add', $product) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label for="quantity-{{ $product->id }}" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" name="quantity" id="quantity-{{ $product->id }}" value="1" min="1" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                        <a href="{{ route('clinic.products.show', $product) }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500">No products found</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-8">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection