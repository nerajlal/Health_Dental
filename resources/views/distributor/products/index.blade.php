@extends('layouts.app')

@section('title', 'My Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="section-title text-4xl mb-2">My Products</h1>
            <p class="text-lg text-gray-600">Manage your product catalog</p>
        </div>
        <a href="{{ route('distributor.products.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Product
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Total Products</p>
            <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Active Products</p>
            <p class="text-3xl font-bold text-green-600" style="font-family: 'Playfair Display', serif;">{{ $stats['active'] ?? 0 }}</p>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Pending Approval</p>
            <p class="text-3xl font-bold text-yellow-600" style="font-family: 'Playfair Display', serif;">{{ $stats['pending'] ?? 0 }}</p>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Low Stock</p>
            <p class="text-3xl font-bold text-orange-600" style="font-family: 'Playfair Display', serif;">{{ $stats['low_stock'] ?? 0 }}</p>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-600 mb-1">Out of Stock</p>
            <p class="text-3xl font-bold text-red-600" style="font-family: 'Playfair Display', serif;">{{ $stats['out_of_stock'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card p-6 mb-8">
        <form action="{{ route('distributor.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, SKU, company..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Filter</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Approved & Active</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Rejected/Inactive</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full btn-primary">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-lg object-cover">
                                @else
                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i class="fas fa-tooth text-gray-400"></i>
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $product->company ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->category)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                {{ $product->category }}
                            </span>
                            @else
                            <span class="text-sm text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">₹{{ number_format($product->base_price, 2) }}</div>
                            <div class="text-sm text-gray-500">per {{ $product->unit }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $product->stock_quantity }}</div>
                            @if($product->stock_quantity == 0)
                            <span class="text-xs text-red-600 font-medium">Out of stock</span>
                            @elseif($product->stock_quantity < 10)
                            <span class="text-xs text-yellow-600 font-medium">Low stock</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->status == 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Pending
                                </span>
                            @elseif($product->status == 'rejected')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i> Rejected
                                </span>
                            @elseif($product->status == 'approved' && $product->is_active)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i> Active
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-pause mr-1"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('distributor.products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-800 hover:bg-red-50 px-3 py-1 rounded transition">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl text-gray-300 mb-2"></i>
                            <p>No products found. <a href="{{ route('distributor.products.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Add your first product</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection