@extends('layouts.app')

@section('title', 'Create Product for Request')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('distributor.product-requests.show', $productRequest) }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Back to Request
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Create Product</h1>
        <p class="mt-2 text-gray-600">Add a new product to fulfill request #{{ $productRequest->id }}</p>
    </div>

    <!-- Request Summary -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">Requested Product Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <label class="text-blue-700 font-medium">Product Name:</label>
                <p class="text-blue-900">{{ $productRequest->product_name }}</p>
            </div>
            @if($productRequest->company)
            <div>
                <label class="text-blue-700 font-medium">Company:</label>
                <p class="text-blue-900">{{ $productRequest->company }}</p>
            </div>
            @endif
            @if($productRequest->category)
            <div>
                <label class="text-blue-700 font-medium">Category:</label>
                <p class="text-blue-900">{{ $productRequest->category }}</p>
            </div>
            @endif
            @if($productRequest->expected_price)
            <div>
                <label class="text-blue-700 font-medium">Expected Price:</label>
                <p class="text-blue-900">${{ number_format($productRequest->expected_price, 2) }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Product Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('distributor.product-requests.store-product', $productRequest) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $productRequest->product_name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU & Company -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            SKU <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="e.g., DG-001">
                        @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                        <input type="text" name="company" value="{{ old('company', $productRequest->company) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Category</option>
                        <option value="Instruments" {{ old('category', $productRequest->category) == 'Instruments' ? 'selected' : '' }}>Instruments</option>
                        <option value="Equipment" {{ old('category', $productRequest->category) == 'Equipment' ? 'selected' : '' }}>Equipment</option>
                        <option value="Consumables" {{ old('category', $productRequest->category) == 'Consumables' ? 'selected' : '' }}>Consumables</option>
                        <option value="Implants" {{ old('category', $productRequest->category) == 'Implants' ? 'selected' : '' }}>Implants</option>
                        <option value="Orthodontics" {{ old('category', $productRequest->category) == 'Orthodontics' ? 'selected' : '' }}>Orthodontics</option>
                        <option value="Endodontics" {{ old('category', $productRequest->category) == 'Endodontics' ? 'selected' : '' }}>Endodontics</option>
                        <option value="Prosthetics" {{ old('category', $productRequest->category) == 'Prosthetics' ? 'selected' : '' }}>Prosthetics</option>
                        <option value="Infection Control" {{ old('category', $productRequest->category) == 'Infection Control' ? 'selected' : '' }}>Infection Control</option>
                        <option value="Other" {{ old('category', $productRequest->category) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Your Base Price (INR) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="base_price" value="{{ old('base_price', $productRequest->expected_price) }}" step="0.01" min="0" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500">Your earning per unit</p>
                        @error('base_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Admin Margin (USD) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="admin_margin" value="{{ old('admin_margin', 2.00) }}" step="0.01" min="0" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500">Platform fee per unit</p>
                        @error('admin_margin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> -->
                </div>

                <!-- Stock & Unit -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stock Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $productRequest->estimated_quantity) }}" min="0" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Unit <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="unit" value="{{ old('unit', 'piece') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="e.g., piece, box, pack">
                        @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $productRequest->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Max 2MB, JPG, PNG, or GIF</p>
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                    <i class="fas fa-check mr-2"></i>Create Product & Fulfill Request
                </button>
                <a href="{{ route('distributor.product-requests.show', $productRequest) }}" class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection