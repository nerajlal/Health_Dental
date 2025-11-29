@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="section-title text-4xl mb-2">Shopping Cart</h1>
        <p class="text-lg text-gray-600">Review your items before placing an order</p>
    </div>

    @if(count($products) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="card">
                @foreach($products as $product)
                <div class="p-6 border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row items-center sm:space-x-4 space-y-4 sm:space-y-0">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="w-24 h-24 object-cover rounded-lg">
                        @else
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-tooth text-3xl text-gray-400"></i>
                        </div>
                        @endif

                        <div class="flex-1 text-center sm:text-left w-full sm:w-auto">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $product->distributor->name }}</p>
                            <p class="text-lg font-bold gradient-text mt-2" style="font-family: 'Playfair Display', serif;">₹{{ number_format($product->display_price, 2) }} <span class="text-sm text-gray-500 font-normal">per {{ $product->unit }}</span></p>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto justify-between sm:justify-end">
                            <form action="{{ route('clinic.cart.update', $product) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <label for="quantity-{{ $product->id }}" class="text-sm font-medium text-gray-600">Qty:</label>
                                <input type="number" name="quantity" id="quantity-{{ $product->id }}" 
                                       value="{{ $product->quantity }}" min="1" 
                                       class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       onchange="this.form.submit()">
                            </form>

                            <div class="text-center sm:text-right">
                                <p class="text-sm text-gray-500">Subtotal</p>
                                <p class="text-lg font-bold text-gray-900">₹{{ number_format($product->subtotal, 2) }}</p>
                            </div>

                            <form action="{{ route('clinic.cart.remove', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <i class="fas fa-trash text-xl"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="card p-6 sticky top-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif;">Order Summary</h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Items ({{ count($products) }})</span>
                        <span>₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax</span>
                        <span>₹0.00</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between text-xl font-bold text-gray-900">
                            <span>Total</span>
                            <span class="gradient-text" style="font-family: 'Playfair Display', serif;">₹{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('clinic.orders.create') }}" 
                   class="block w-full btn-primary text-center py-3 mb-3">
                    <i class="fas fa-check mr-2"></i>Proceed to Checkout
                </a>

                <a href="{{ route('clinic.products.index') }}" 
                   class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-center px-6 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-shopping-bag mr-2"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="card p-12 text-center">
        <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
        <h2 class="text-3xl font-semibold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">Your cart is empty</h2>
        <p class="text-gray-600 mb-6">Start adding products to your cart</p>
        <a href="{{ route('clinic.products.index') }}" 
           class="inline-block btn-primary">
            <i class="fas fa-search mr-2"></i>Browse Products
        </a>
    </div>
    @endif
</div>
@endsection