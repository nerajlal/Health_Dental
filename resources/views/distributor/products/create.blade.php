@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Add New Product</h1>
        <p class="mt-2 text-gray-600">Add a product to your catalog</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('distributor.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Product Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            <img id="preview" class="h-32 w-32 object-cover rounded-lg" src="https://via.placeholder.com/150" alt="Product preview">
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose product image</span>
                            <input type="file" name="image" accept="image/*" onchange="previewImage(event)"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </label>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., Dental Composite Resin">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., COMP-001">
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company/Brand</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., 3M ESPE">
                        @error('company')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select category</option>
                        <option value="Restorative Materials" {{ old('category') == 'Restorative Materials' ? 'selected' : '' }}>Restorative Materials</option>
                        <option value="Preventive Materials" {{ old('category') == 'Preventive Materials' ? 'selected' : '' }}>Preventive Materials</option>
                        <option value="Endodontic Materials" {{ old('category') == 'Endodontic Materials' ? 'selected' : '' }}>Endodontic Materials</option>
                        <option value="Prosthetic Materials" {{ old('category') == 'Prosthetic Materials' ? 'selected' : '' }}>Prosthetic Materials</option>
                        <option value="Surgical Instruments" {{ old('category') == 'Surgical Instruments' ? 'selected' : '' }}>Surgical Instruments</option>
                        <option value="Orthodontic Materials" {{ old('category') == 'Orthodontic Materials' ? 'selected' : '' }}>Orthodontic Materials</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Detailed product description...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Base Price -->
                    <div>
                        <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">Base Price (USD) *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500 font-medium">$</span>
                            <input type="number" name="base_price" id="base_price" value="{{ old('base_price') }}" step="0.01" min="0" required
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00">
                        </div>
                        @error('base_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity') }}" min="0" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0">
                        @error('stock_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unit -->
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                        <select name="unit" id="unit" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="piece" {{ old('unit') == 'piece' ? 'selected' : '' }}>Piece</option>
                            <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Box</option>
                            <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>Pack</option>
                            <option value="bottle" {{ old('unit') == 'bottle' ? 'selected' : '' }}>Bottle</option>
                            <option value="kit" {{ old('unit') == 'kit' ? 'selected' : '' }}>Kit</option>
                            <option value="set" {{ old('unit') == 'set' ? 'selected' : '' }}>Set</option>
                        </select>
                        @error('unit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Product is Active
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('distributor.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Add Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('preview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection