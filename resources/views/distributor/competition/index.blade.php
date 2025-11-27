@extends('layouts.app')

@section('title', 'Competition Analysis')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Competition Analysis
        </h1>
        <p class="mt-2 text-gray-600">See what your competitors are selling and compare prices</p>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('distributor.competition.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Search by product name, SKU, or category..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            @if($search)
            <a href="{{ route('distributor.competition.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-times"></i>
            </a>
            @endif
        </form>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
            <div>
                <h3 class="font-semibold text-blue-900 mb-1">How Competition Analysis Works</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• View products from other distributors in the system</li>
                    <li>• Click on any product to see detailed price rankings</li>
                    <li>• <span class="text-green-600 font-semibold">Green badges</span> show where you're offering better prices</li>
                    <li>• <span class="text-red-600 font-semibold">Red badges</span> show where competitors are cheaper</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Competitor Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Competitor Products</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Competitor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Their Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Your Price</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Comparison</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($competitorProducts as $product)
                    <tr class="hover:bg-gray-50">
                        <!-- Product -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-12 h-12 rounded object-cover mr-3">
                                @else
                                <div class="w-12 h-12 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-box text-gray-400"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Competitor -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->distributor->name }}</div>
                            <div class="text-xs text-gray-500">{{ $product->distributor->email }}</div>
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                {{ $product->category ?? 'N/A' }}
                            </span>
                        </td>

                        <!-- Their Price -->
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="text-sm font-bold text-gray-900">₹{{ number_format($product->base_price, 2) }}</div>
                            <div class="text-xs text-gray-500">per {{ $product->unit }}</div>
                        </td>

                        <!-- Your Price -->
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if($product->my_product)
                                <div class="text-sm font-bold text-blue-600">₹{{ number_format($product->my_product->base_price, 2) }}</div>
                                <div class="text-xs text-gray-500">per {{ $product->my_product->unit }}</div>
                            @else
                                <span class="text-xs text-gray-400">Not selling</span>
                            @endif
                        </td>

                        <!-- Comparison -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($product->my_product)
                                @php
                                    $priceDiff = $product->my_product->base_price - $product->base_price;
                                @endphp
                                
                                @if($priceDiff > 0)
                                    {{-- You are more expensive (They're cheaper) --}}
                                    <div class="inline-flex flex-col items-center">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-arrow-up mr-1"></i>They're Cheaper
                                        </span>
                                        <span class="text-xs text-red-600 font-medium mt-1">
                                            ₹{{ number_format($priceDiff, 2) }} more than them
                                        </span>
                                    </div>
                                @elseif($priceDiff < 0)
                                    {{-- You are less expensive (You're cheaper) --}}
                                    <div class="inline-flex flex-col items-center">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-arrow-down mr-1"></i>You're Cheaper
                                        </span>
                                        <span class="text-xs text-green-600 font-medium mt-1">
                                            ₹{{ number_format(abs($priceDiff), 2) }} less than them
                                        </span>
                                    </div>
                                @else
                                    {{-- Same price --}}
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-equals mr-1"></i>Same Price
                                    </span>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">Not selling this product</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('distributor.competition.product', $product) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded">
                                <i class="fas fa-chart-bar mr-1"></i>View Rankings
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-users-slash text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500 text-lg">No competitor products found</p>
                            <p class="text-gray-400 text-sm">Try adjusting your search criteria</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $competitorProducts->appends(['search' => $search])->links() }}
    </div>
</div>
@endsection