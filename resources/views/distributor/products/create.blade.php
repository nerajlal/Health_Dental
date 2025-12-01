@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="section-title text-3xl mb-2">Add New Product</h1>
        <p class="text-lg text-gray-600">Add a product to your catalog</p>
    </div>

    <div class="card p-6">
        <form action="{{ route('distributor.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Product Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            <img id="preview" class="h-32 w-32 object-cover rounded-lg border-2 border-gray-200" src="https://via.placeholder.com/150" alt="Product preview">
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
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="e.g., COMP-001">
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company/Brand</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="e.g., 3M ESPE">
                        @error('company')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Detailed product description...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Base Price -->
                    <div>
                        <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">Base Price (INR) *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500 font-medium">₹</span>
                            <input type="number" name="base_price" id="base_price" value="{{ old('base_price') }}" step="0.01" min="0" required
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="0">
                        @error('stock_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unit -->
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                        <select name="unit" id="unit" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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

                <!-- Competitor Price Alert -->
                <div id="competitor-alert" class="hidden"></div>

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
                    <a href="{{ route('distributor.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Add Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Product Details Modal -->
<div id="productModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Competitor Product Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="modalContent"></div>
        </div>
    </div>
</div>

<script>
// Image preview
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('preview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Competitor price checking
let priceCheckTimeout;
let competitorsData = [];

function checkCompetitorPrice() {
    clearTimeout(priceCheckTimeout);
    
    priceCheckTimeout = setTimeout(() => {
        const sku = document.getElementById('sku').value;
        const name = document.getElementById('name').value;
        const company = document.getElementById('company').value;
        const basePrice = parseFloat(document.getElementById('base_price').value);
        
        // Need at least SKU or (name + company)
        if (!sku && (!name || !company)) {
            hideCompetitorAlert();
            return;
        }
        
        // Fetch competitor prices
        fetch(`{{ route('distributor.products.check-price') }}?sku=${encodeURIComponent(sku)}&name=${encodeURIComponent(name)}&company=${encodeURIComponent(company)}`)
            .then(response => response.json())
            .then(data => {
                competitorsData = data.competitors || [];
                if (data.has_competitors) {
                    showCompetitorAlert(data, basePrice);
                } else {
                    hideCompetitorAlert();
                }
            })
            .catch(error => {
                console.error('Error checking prices:', error);
                hideCompetitorAlert();
            });
    }, 500); // Debounce 500ms
}

function showCompetitorAlert(data, myPrice) {
    const alertDiv = document.getElementById('competitor-alert');
    const lowestPrice = data.lowest_price;
    const lowestDistributor = data.lowest_price_distributor;
    
    if (!lowestPrice) {
        hideCompetitorAlert();
        return;
    }
    
    let html = '';
    
    if (!myPrice || myPrice === 0) {
        // No price entered yet
        html = `
            <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 text-xl mt-1 mr-3"></i>
                    <div class="flex-1">
                        <p class="font-semibold text-blue-900">Market Price Information</p>
                        <p class="text-sm text-blue-800 mt-1">
                            Lowest market price: <span class="font-bold">₹${lowestPrice.toFixed(2)}</span> by ${lowestDistributor}
                        </p>
                        <button type="button" onclick="showProductDetails(0)" class="text-sm text-blue-600 hover:text-blue-800 font-semibold mt-2 underline">
                            View competitor details →
                        </button>
                    </div>
                </div>
            </div>
        `;
    } else {
        const priceDiff = myPrice - lowestPrice;
        const percentDiff = ((priceDiff / lowestPrice) * 100).toFixed(1);
        
        if (myPrice <= lowestPrice) {
            // Competitive pricing
            html = `
                <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mt-1 mr-3"></i>
                        <div class="flex-1">
                            <p class="font-semibold text-green-900">✓ Competitive Pricing!</p>
                            <p class="text-sm text-green-800 mt-1">
                                Your price is ${myPrice < lowestPrice ? percentDiff + '% lower than' : 'equal to'} the market lowest (₹${lowestPrice.toFixed(2)})
                            </p>
                            <button type="button" onclick="showProductDetails(0)" class="text-sm text-green-600 hover:text-green-800 font-semibold mt-2 underline">
                                View competitor details →
                            </button>
                        </div>
                    </div>
                </div>
            `;
        } else if (percentDiff <= 10) {
            // Slightly above market
            html = `
                <div class="border-l-4 border-yellow-500 bg-yellow-50 p-4 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-1 mr-3"></i>
                        <div class="flex-1">
                            <p class="font-semibold text-yellow-900">⚠ Slightly Above Market</p>
                            <p class="text-sm text-yellow-800 mt-1">
                                <span class="font-bold">${lowestDistributor}</span> is selling at <span class="font-bold">₹${lowestPrice.toFixed(2)}</span> which is <span class="font-bold">${percentDiff}% lower</span> than your price
                            </p>
                            <button type="button" onclick="showProductDetails(0)" class="text-sm text-yellow-600 hover:text-yellow-800 font-semibold mt-2 underline">
                                Click to view their product details →
                            </button>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Significantly above market
            html = `
                <div class="border-l-4 border-red-500 bg-red-50 p-4 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl mt-1 mr-3"></i>
                        <div class="flex-1">
                            <p class="font-semibold text-red-900">⚠ Price Above Market</p>
                            <p class="text-sm text-red-800 mt-1">
                                <span class="font-bold">${lowestDistributor}</span> is selling at <span class="font-bold">₹${lowestPrice.toFixed(2)}</span> which is <span class="font-bold">${percentDiff}% lower</span> than your price
                            </p>
                            <button type="button" onclick="showProductDetails(0)" class="text-sm text-red-600 hover:text-red-800 font-semibold mt-2 underline">
                                Click to view their product details →
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
    }
    
    alertDiv.innerHTML = html;
    alertDiv.classList.remove('hidden');
}

function hideCompetitorAlert() {
    document.getElementById('competitor-alert').classList.add('hidden');
}

function showProductDetails(index) {
    if (!competitorsData || competitorsData.length === 0) return;
    
    const product = competitorsData[index];
    const modal = document.getElementById('productModal');
    const content = document.getElementById('modalContent');
    
    content.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                ${product.image ? 
                    `<img src="${product.image}" alt="${product.name}" class="w-full h-64 object-cover rounded-lg">` :
                    `<div class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tooth text-gray-400 text-6xl"></i>
                    </div>`
                }
            </div>
            <div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">${product.name}</h4>
                <p class="text-gray-600 mb-4">${product.company || 'N/A'}</p>
                
                ${product.category ? `<span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 text-sm font-semibold rounded-full mb-4">${product.category}</span>` : ''}
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">SKU:</span>
                        <span class="font-semibold">${product.sku}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Unit:</span>
                        <span class="font-semibold">${product.unit}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Stock:</span>
                        <span class="font-semibold">${product.stock_quantity}</span>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-600 mb-1">Final Price</p>
                    <p class="text-3xl font-bold gradient-text" style="font-family: 'Playfair Display', serif;">₹${product.final_price.toFixed(2)}</p>
                    <p class="text-xs text-gray-500 mt-1">Base: ₹${product.base_price.toFixed(2)} + Margin: ₹${product.admin_margin.toFixed(2)}</p>
                </div>
            </div>
        </div>
        
        ${product.description ? `
            <div class="mt-6 pt-6 border-t">
                <h5 class="font-semibold text-gray-900 mb-2">Description</h5>
                <p class="text-gray-600 text-sm">${product.description}</p>
            </div>
        ` : ''}
        
        <div class="mt-6 pt-6 border-t">
            <h5 class="font-semibold text-gray-900 mb-3">Distributor Information</h5>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="font-semibold text-gray-900">${product.distributor.name}</p>
            </div>
        </div>
        
        ${competitorsData.length > 1 ? `
            <div class="mt-6 pt-6 border-t">
                <h5 class="font-semibold text-gray-900 mb-3">Other Competitors (${competitorsData.length - 1})</h5>
                <div class="space-y-2">
                    ${competitorsData.slice(1, 4).map((comp, idx) => `
                        <button type="button" onclick="showProductDetails(${idx + 1})" class="w-full text-left p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900">${comp.name}</p>
                                    <p class="text-sm text-gray-600">${comp.distributor.name}</p>
                                </div>
                                <p class="text-lg font-bold text-blue-600">₹${comp.final_price.toFixed(2)}</p>
                            </div>
                        </button>
                    `).join('')}
                </div>
            </div>
        ` : ''}
    `;
    
    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('productModal').classList.add('hidden');
}

// Attach event listeners
document.getElementById('sku').addEventListener('input', checkCompetitorPrice);
document.getElementById('name').addEventListener('input', checkCompetitorPrice);
document.getElementById('company').addEventListener('input', checkCompetitorPrice);
document.getElementById('base_price').addEventListener('input', checkCompetitorPrice);

// Close modal on outside click
document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection