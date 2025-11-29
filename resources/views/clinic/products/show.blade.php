@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-8">
        <a href="{{ route('clinic.products.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Back to Products
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="card p-6">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
            @else
            <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                <i class="fas fa-tooth text-gray-400 text-6xl"></i>
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <div class="card p-6">
                <h1 class="section-title text-3xl mb-2">{{ $product->name }}</h1>
                <p class="text-lg text-gray-600 mb-4">{{ $product->company ?? 'N/A' }}</p>
                
                @if($product->category)
                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 text-sm font-semibold rounded-full mb-4">
                    {{ $product->category }}
                </span>
                @endif

                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">SKU</p>
                            <p class="font-semibold text-gray-900">{{ $product->sku }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Unit</p>
                            <p class="font-semibold text-gray-900">{{ $product->unit }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Available Stock</p>
                            <p class="font-semibold text-gray-900">{{ $product->stock_quantity }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Distributor</p>
                            <p class="font-semibold text-gray-900">{{ $product->distributor->name }}</p>
                        </div>
                    </div>
                </div>

                @if($product->description)
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <p class="text-sm font-medium text-gray-600 mb-2">Description</p>
                    <p class="text-gray-900">{{ $product->description }}</p>
                </div>
                @endif
            </div>

            <!-- Pricing & Add to Cart -->
            <div class="card p-6">
                <div class="mb-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Price per {{ $product->unit }}</p>
                    <p class="text-4xl font-bold gradient-text" style="font-family: 'Playfair Display', serif;">₹{{ number_format($price, 2) }}</p>
                    @if($hasCustomPricing)
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                        <i class="fas fa-star mr-1"></i>Special pricing for your clinic
                    </span>
                    @endif
                </div>

                <form action="{{ route('clinic.cart.add', $product) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="decrementQuantity()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                   class="w-24 px-4 py-2 border border-gray-300 rounded-lg text-center focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" onclick="incrementQuantity()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Maximum: {{ $product->stock_quantity }} available</p>
                    </div>

                    <div class="space-y-3">
                        <button type="submit" class="w-full btn-primary text-lg py-3">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="card p-6 mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6" style="font-family: 'Playfair Display', serif;">Additional Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-start space-x-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-truck text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Fast Delivery</h3>
                    <p class="text-sm text-gray-600">Orders processed within 2-3 business days</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Quality Assured</h3>
                    <p class="text-sm text-gray-600">All products verified by admin</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-headset text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Support Available</h3>
                    <p class="text-sm text-gray-600">Contact us for any questions</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}
</script>
@endsection