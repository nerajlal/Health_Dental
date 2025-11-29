@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="section-title text-4xl mb-2">Manage Products</h1>
            <p class="text-lg text-gray-600">View and manage all products from distributors</p>
        </div>
        <a href="{{ route('admin.products.pending') }}" class="btn-primary bg-yellow-600 hover:bg-yellow-700">
            <i class="fas fa-clock mr-2"></i>Pending Approval ({{ $pendingCount ?? 0 }})
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="card p-6 mb-8">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Distributor</label>
                <select name="distributor" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Distributors</option>
                    @foreach($distributors as $distributor)
                    <option value="{{ $distributor->id }}" {{ request('distributor') == $distributor->id ? 'selected' : '' }}>
                        {{ $distributor->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Distributor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pricing</th>
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
                            <div class="text-sm font-medium text-gray-900">{{ $product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->distributor->name }}</div>
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
                            <div class="text-sm text-gray-600">Base: <span class="font-semibold text-gray-900">₹{{ number_format($product->base_price, 2) }}</span></div>
                            @if($product->status == 'approved' && $product->admin_margin)
                            <div class="text-sm text-gray-600">Margin: <span class="font-semibold text-green-600">+₹{{ number_format($product->admin_margin, 2) }}</span></div>
                            <div class="text-sm text-gray-600">Final: <span class="font-bold gradient-text" style="font-family: 'Playfair Display', serif;">₹{{ number_format($product->final_price, 2) }}</span></div>
                            @endif
                            <div class="text-xs text-gray-500">per {{ $product->unit }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->status == 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Pending
                                </span>
                            @elseif($product->status == 'rejected')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Rejected
                                </span>
                            @elseif($product->status == 'approved' && $product->is_active)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Active
                                </span>
                            @elseif($product->status == 'approved' && !$product->is_active)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-pause-circle mr-1"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($product->status == 'approved')
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-2 py-1 rounded transition mr-2" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.products.custom-pricing', $product) }}" class="text-green-600 hover:text-green-800 hover:bg-green-50 px-2 py-1 rounded transition" title="Custom Pricing">
                                    <i class="fas fa-dollar-sign"></i>
                                </a>
                            @elseif($product->status == 'pending')
                                <a href="{{ route('admin.products.pending') }}" class="text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 px-2 py-1 rounded transition" title="Review">
                                    <i class="fas fa-eye"></i> Review
                                </a>
                            @elseif($product->status == 'rejected')
                                <span class="text-xs text-gray-500">Awaiting resubmission</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl text-gray-300 mb-2"></i>
                            <p>No products found.</p>
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