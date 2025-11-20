@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
        <p class="mt-2 text-gray-600">Review your items before checkout</p>
    </div>

    @if($products->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Cart Items ({{ $products->count() }})</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($products as $product)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-20 h-20 rounded object-cover">
                            @else
                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                <i class="fas fa-tooth text-gray-400 text-xl"></i>
                            </div>
                            @endif

                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $product->distributor->name }}</p>
                                <p class="text-sm text-gray-600 mt-1">SKU: {{ $product->sku }}</p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <!-- Quantity Controls -->
                                <form action="{{ route('clinic.cart.update', $product) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" onclick="decreaseQty({{ $product->id }})" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center">
                                        <i class="fas fa-minus text-sm"></i>
                                    </button>
                                    <input type="number" name="quantity" id="qty-{{ $product->id }}" value="{{ $product->quantity }}" min="1" max="{{ $product->stock_quantity }}"
                                           class="w-16 text-center border border-gray-300 rounded py-1"
                                           onchange="this.form.submit()">
                                    <button type="button" onclick="increaseQty({{ $product->id }}, {{ $product->stock_quantity }})" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </form>

                                <!-- Price -->
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }} each</p>
                                    <p class="text-lg font-bold text-gray-900">${{ number_format($product->subtotal, 2) }}</p>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('clinic.cart.remove', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Remove this item?')" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Summary -->
        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal ({{ $products->count() }} items)</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (0%)</span>
                        <span>$0.00</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>Calculated at checkout</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between text-xl font-bold text-gray-900">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <form action="{{ route('clinic.orders.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium mb-3">
                        <i class="fas fa-shopping-cart mr-2"></i>Proceed to Checkout
                    </button>
                </form>

                <a href="{{ route('clinic.products.index') }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Continue Shopping
                </a>

                <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <p class="text-xs text-yellow-900">
                        <i class="fas fa-info-circle mr-1"></i>
                        Your order will be pending until approved by admin.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Your Cart is Empty</h2>
        <p class="text-gray-600 mb-6">Add some products to your cart to get started</p>
        <a href="{{ route('clinic.products.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-box-open mr-2"></i>Browse Products
        </a>
    </div>
    @endif
</div>

<script>
function increaseQty(productId, maxQty) {
    const input = document.getElementById('qty-' + productId);
    const currentValue = parseInt(input.value);
    if (currentValue < maxQty) {
        input.value = currentValue + 1;
        input.form.submit();
    }
}

function decreaseQty(productId) {
    const input = document.getElementById('qty-' + productId);
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
        input.form.submit();
    }
}
</script>
@endsection