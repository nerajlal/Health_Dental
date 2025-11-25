@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
        <p class="mt-2 text-gray-600">Update product information and assign distributor</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Information (Read-Only)</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                            <input type="text" value="{{ $product->name }}" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                            <input type="text" value="{{ $product->sku }}" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Base Price</label>
                            <input type="text" value="₹{{ number_format($product->base_price, 2) }}" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                            <input type="text" value="{{ $product->stock_quantity }}" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                            <input type="text" value="{{ $product->unit }}" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        </div>
                    </div>

                    @if($product->category)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <input type="text" value="{{ $product->category }}" disabled
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                    </div>
                    @endif

                    @if($product->description)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea disabled rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">{{ $product->description }}</textarea>
                    </div>
                    @endif
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Settings</h3>

                    <div>
                        <label for="distributor_id" class="block text-sm font-medium text-gray-700 mb-2">Assign Distributor *</label>
                        <select name="distributor_id" id="distributor_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @foreach($distributors as $distributor)
                            <option value="{{ $distributor->id }}" {{ $product->distributor_id == $distributor->id ? 'selected' : '' }}>
                                {{ $distributor->name }}
                            </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Manually assign this product to a specific distributor for quality control</p>
                        @error('distributor_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4 flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Product is Active
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium">
                        Cancel
                    </a>
                    <a href="{{ route('admin.products.custom-pricing', $product) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium">
                        <i class="fas fa-dollar-sign mr-2"></i>Custom Pricing
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection