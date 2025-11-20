@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create New Order</h1>
        <p class="mt-2 text-gray-600">Select products and place your order</p>
    </div>

    <form action="{{ route('clinic.orders.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Selection -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Select Products</h2>
                    
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <input type="text" id="productSearch" placeholder="Search products..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               onkeyup="filterProducts()">
                    </div>

                    <!-- Product List -->
                    <div id="productList" class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($products as $product)
                        <div class="product-item flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-blue-500 transition" data-name="{{ strtolower($product->name) }}" data-sku="{{ strtolower($product->sku) }}">
                            <div class="flex items-center space-x-4 flex-1">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 rounded object-cover">
                                @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-tooth text-gray-400"></i>
                                </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                                    <p class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }}</p>
                                    <p class="font-medium text-blue-600">${{ number_format($product->display_price, 2) }} per {{ $product->unit }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="number" name="products[{{ $product->id }}][quantity]" 
                                       class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-center product-quantity"
                                       min="0" max="{{ $product->stock_quantity }}" value="0"
                                       data-price="{{ $product->display_price }}"
                                       data-product-id="{{ $product->id }}"
                                       onchange="updateOrderSummary()">
                                <span class="text-gray-600">×</span>
                                <span class="font-medium text-gray-900">${{ number_format($product->display_price, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                    
                    <div id="selectedItems" class="space-y-2 mb-4 max-h-48 overflow-y-auto">
                        <p class="text-sm text-gray-500 text-center py-4">No items selected</p>
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Items:</span>
                            <span id="totalItems" class="font-medium text-gray-900">0</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold">
                            <span class="text-gray-900">Total Amount:</span>
                            <span id="totalAmount" class="text-gray-900">$0.00</span>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <button type="submit" id="placeOrderBtn" disabled
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white px-6 py-3 rounded-lg font-medium">
                            <i class="fas fa-shopping-cart mr-2"></i>Place Order
                        </button>
                        <a href="{{ route('clinic.products.index') }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium">
                            Cancel
                        </a>
                    </div>

                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs text-blue-900">
                            <i class="fas fa-info-circle mr-1"></i>
                            Your order will be pending until approved by admin.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function filterProducts() {
    const search = document.getElementById('productSearch').value.toLowerCase();
    const products = document.querySelectorAll('.product-item');
    
    products.forEach(product => {
        const name = product.getAttribute('data-name');
        const sku = product.getAttribute('data-sku');
        if (name.includes(search) || sku.includes(search)) {
            product.style.display = '';
        } else {
            product.style.display = 'none';
        }
    });
}

function updateOrderSummary() {
    const quantities = document.querySelectorAll('.product-quantity');
    let totalItems = 0;
    let totalAmount = 0;
    let selectedItemsHTML = '';
    let hasItems = false;

    quantities.forEach(input => {
        const quantity = parseInt(input.value) || 0;
        if (quantity > 0) {
            hasItems = true;
            const price = parseFloat(input.getAttribute('data-price'));
            const productElement = input.closest('.product-item');
            const productName = productElement.querySelector('h3').textContent;
            
            totalItems += quantity;
            totalAmount += quantity * price;
            
            selectedItemsHTML += `
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">${productName} (×${quantity})</span>
                    <span class="font-medium text-gray-900">$${(quantity * price).toFixed(2)}</span>
                </div>
            `;
        }
    });

    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalAmount').textContent = '$' + totalAmount.toFixed(2);
    
    const selectedItemsDiv = document.getElementById('selectedItems');
    if (hasItems) {
        selectedItemsDiv.innerHTML = selectedItemsHTML;
        document.getElementById('placeOrderBtn').disabled = false;
    } else {
        selectedItemsDiv.innerHTML = '<p class="text-sm text-gray-500 text-center py-4">No items selected</p>';
        document.getElementById('placeOrderBtn').disabled = true;
    }
}
</script>
@endsection