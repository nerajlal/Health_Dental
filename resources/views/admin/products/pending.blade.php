@extends('layouts.app')

@section('title', 'Pending Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Pending Products Approval</h1>
        <p class="mt-2 text-gray-600">Review and approve products submitted by distributors</p>
    </div>

    <div class="space-y-6">
        @forelse($products as $product)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Product Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-start space-x-4">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 rounded object-cover">
                        @else
                        <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                            <i class="fas fa-tooth text-gray-400 text-2xl"></i>
                        </div>
                        @endif
                        
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $product->company ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600 mt-2">{{ $product->description }}</p>
                            
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <p class="text-xs text-gray-500">SKU</p>
                                    <p class="font-medium text-gray-900">{{ $product->sku }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Category</p>
                                    <p class="font-medium text-gray-900">{{ $product->category ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Base Price (from distributor)</p>
                                    <p class="text-lg font-bold text-gray-900">${{ number_format($product->base_price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Stock Quantity</p>
                                    <p class="font-medium text-gray-900">{{ $product->stock_quantity }} {{ $product->unit }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <p class="text-xs text-gray-500">Distributor</p>
                                <p class="font-medium text-gray-900">{{ $product->distributor->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approval Form -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-900 mb-4">Set Pricing & Approve</h4>
                    
                    <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <!-- Admin Margin -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Add Your Margin *</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" name="admin_margin" step="0.01" min="0" required
                                           class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="0.00"
                                           onchange="calculateFinalPrice({{ $product->id }}, {{ $product->base_price }}, this.value)">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Add your profit margin on top of base price</p>
                            </div>

                            <!-- Final Price Display -->
                            <div class="bg-white p-3 rounded border border-gray-300">
                                <p class="text-xs text-gray-500">Final Clinic Price:</p>
                                <p class="text-2xl font-bold text-green-600" id="final-price-{{ $product->id }}">
                                    ${{ number_format($product->base_price, 2) }}
                                </p>
                            </div>

                            <!-- Admin Notes -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optional)</label>
                                <textarea name="admin_notes" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Any notes about this product..."></textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-2">
                                <button type="submit" name="action" value="approve" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                                    <i class="fas fa-check mr-2"></i>Approve Product
                                </button>
                                <button type="submit" name="action" value="reject"
                                        onclick="return confirm('Are you sure you want to reject this product?')"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                                    <i class="fas fa-times mr-2"></i>Reject Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">No Pending Products</h2>
            <p class="text-gray-600">All products have been reviewed</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>

<script>
function calculateFinalPrice(productId, basePrice, margin) {
    margin = parseFloat(margin) || 0;
    const finalPrice = parseFloat(basePrice) + margin;
    document.getElementById('final-price-' + productId).textContent = '$' + finalPrice.toFixed(2);
}
</script>
@endsection