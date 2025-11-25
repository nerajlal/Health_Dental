@extends('layouts.app')

@section('title', 'Shopping Bag')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Shopping Bag</h1>
        <p class="mt-2 text-gray-600">These items will be saved for future orders.</p>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
    @endif

    @if(count($bagItems) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Bag Items -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($bagItems as $item)
            @php $product = $item->product; @endphp
            <div class="bg-white rounded-lg shadow hover:shadow-md transition">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <!-- Product Image & Info -->
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 rounded object-cover flex-shrink-0">
                            @else
                            <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-tooth text-gray-400 text-xl"></i>
                            </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 text-lg truncate">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $product->distributor->name }}</p>
                                <p class="text-sm text-gray-600 mt-1">SKU: {{ $product->sku }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-sm text-gray-500">${{ number_format($product->price, 2) }} each</span>
                                    @if($product->stock_quantity < 10)
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                                        Only {{ $product->stock_quantity }} left
                                    </span>
                                    @elseif($product->stock_quantity == 0)
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                        Out of Stock
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Controls -->
                        <form action="{{ route('clinic.bag.update', $product) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <button type="button" onclick="decreaseQty({{ $product->id }})" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center">
                                <i class="fas fa-minus text-sm"></i>
                            </button>
                            <input type="number" name="quantity" id="qty-{{ $product->id }}" value="{{ $item->quantity }}" min="1" max="{{ $product->stock_quantity }}"
                                   class="w-16 text-center border border-gray-300 rounded py-1"
                                   onchange="this.form.submit()">
                            <button type="button" onclick="increaseQty({{ $product->id }}, {{ $product->stock_quantity }})" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </form>

                        <!-- Price & Actions -->
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="text-xl font-bold text-gray-900">${{ number_format($product->subtotal, 2) }}</p>
                            </div>

                            <form action="{{ route('clinic.bag.remove', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Remove this item from your bag?')" class="text-red-600 hover:text-red-800 p-2" title="Remove from bag">
                                    <i class="fas fa-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Bag Summary & Quick Order -->
        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Bag Summary</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Items ({{ count($bagItems) }})</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (0%)</span>
                        <span>$0.00</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between text-xl font-bold text-gray-900">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <!-- Quick Order Button -->
                <form action="{{ route('clinic.bag.quick-order') }}" method="POST" class="mb-4">
                    @csrf
                    <button type="submit" onclick="return confirm('Place order for all items in your bag?\n\nNote: Items will remain in your bag for future orders.')" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-bolt mr-2"></i>Quick Order All Items
                    </button>
                    <p class="text-xs text-center text-gray-500 mt-2">
                        Items will stay in your bag after ordering
                    </p>
                </form>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-900">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Quick Order:</strong><br>
                        Place an order for all items in your bag instantly. Items remain saved for future reorders.
                    </p>
                </div>

                <a href="{{ route('clinic.products.index') }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-arrow-left mr-2"></i>Continue Shopping
                </a>

                <!-- Additional Info -->
                <div class="mt-6 bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-purple-900 mb-2">
                        <i class="fas fa-shopping-basket mr-1"></i>About Your Bag
                    </h3>
                    <ul class="text-xs text-purple-800 space-y-1">
                        <li>✓ Items are saved permanently</li>
                        <li>✓ Quick reorder anytime</li>
                        <li>✓ Stays after placing orders</li>
                        <li>✓ Perfect for regular supplies</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Bag -->
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <i class="fas fa-shopping-basket text-gray-300 text-6xl mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Your Bag is Empty</h2>
        <p class="text-gray-600 mb-6">Add products to your bag for quick reordering of frequently used items.</p>
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