@extends('layouts.app')

@section('title', 'Price Rankings - ' . $selectedProduct->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('distributor.competition.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Competition
        </a>
    </div>

    <!-- Product Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-start gap-6">
            @if($selectedProduct->image)
            <img src="{{ asset('storage/' . $selectedProduct->image) }}" 
                 alt="{{ $selectedProduct->name }}" 
                 class="w-32 h-32 rounded-lg object-cover">
            @else
            <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-gray-400 text-4xl"></i>
            </div>
            @endif

            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $selectedProduct->name }}</h1>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">SKU:</span>
                        <span class="font-medium text-gray-900 ml-2">{{ $selectedProduct->sku }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Category:</span>
                        <span class="font-medium text-gray-900 ml-2">{{ $selectedProduct->category ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Sold by:</span>
                        <span class="font-medium text-gray-900 ml-2">{{ $selectedProduct->distributor->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Their Price:</span>
                        <span class="font-bold text-blue-600 ml-2 text-lg">₹{{ number_format($selectedProduct->base_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Price Rankings -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
            <h2 class="text-xl font-semibold text-gray-900">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>Price Rankings - Similar Products
            </h2>
            <p class="text-sm text-gray-600 mt-1">All distributors offering similar products, ranked by price (lowest to highest)</p>
        </div>

        <div class="p-6">
            <div class="space-y-4">
                @foreach($rankedProducts as $product)
                <div class="relative border rounded-lg p-4 transition-all {{ $product->is_mine ? 'border-blue-500 bg-blue-50 shadow-md' : 'border-gray-200 hover:border-gray-300' }}">
                    <!-- Rank Badge -->
                    <div class="absolute -top-3 -left-3">
                        @if($product->rank === 1)
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center shadow-lg">
                                <i class="fas fa-crown text-white text-xl"></i>
                            </div>
                        @elseif($product->rank === 2)
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-300 to-gray-500 flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-lg">2</span>
                            </div>
                        @elseif($product->rank === 3)
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-lg">3</span>
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center shadow">
                                <span class="text-gray-600 font-bold text-lg">{{ $product->rank }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- "YOU" Badge -->
                    @if($product->is_mine)
                    <div class="absolute -top-3 -right-3">
                        <div class="px-4 py-1 rounded-full bg-blue-600 text-white text-xs font-bold shadow-lg">
                            <i class="fas fa-user mr-1"></i>YOU
                        </div>
                    </div>
                    @endif

                    <!-- Cheapest Badge -->
                    @if($product->is_cheapest)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
                            <i class="fas fa-indian-rupee-sign mr-1"></i>LOWEST PRICE
                        </span>
                    </div>
                    @endif

                    <div class="flex items-center gap-4 ml-8">
                        <!-- Product Image -->
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-20 h-20 rounded object-cover">
                        @else
                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                            <i class="fas fa-box text-gray-400 text-2xl"></i>
                        </div>
                        @endif

                        <!-- Product Info -->
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 text-lg">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-building mr-2 text-gray-400"></i>
                                    <span class="{{ $product->is_mine ? 'font-semibold text-blue-600' : '' }}">
                                        {{ $product->distributor->name }}
                                    </span>
                                </div>
                                @if($product->category)
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                    {{ $product->category }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="text-right">
                            <div class="text-3xl font-bold {{ $product->is_mine ? 'text-blue-600' : 'text-gray-900' }}">
                                ₹{{ number_format($product->base_price, 2) }}
                            </div>
                            <div class="text-sm text-gray-500">per {{ $product->unit }}</div>
                            
                            @if(!$product->is_cheapest && $rankedProducts->first())
                                @php
                                    $cheapestPrice = $rankedProducts->first()->base_price;
                                    $difference = $product->base_price - $cheapestPrice;
                                @endphp
                                <div class="text-xs text-red-600 font-medium mt-1">
                                    +₹{{ number_format($difference, 2) }} vs lowest
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Info -->
                    <div class="mt-3 flex items-center gap-4 text-xs text-gray-500 ml-8">
                        <div>
                            <i class="fas fa-boxes mr-1"></i>
                            Stock: {{ $product->stock_quantity }} {{ $product->unit }}
                        </div>
                        @if($product->is_mine)
                        <!-- <a href="{{ route('distributor.products.edit', $product) }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-edit mr-1"></i>Edit Your Product
                        </a> -->
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary Stats -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                    <div class="text-sm text-blue-600 font-medium mb-1">Total Competitors</div>
                    <div class="text-2xl font-bold text-blue-900">{{ $rankedProducts->count() }}</div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                    <div class="text-sm text-green-600 font-medium mb-1">Lowest Price</div>
                    <div class="text-2xl font-bold text-green-900">
                        ₹{{ number_format($rankedProducts->first()->base_price ?? 0, 2) }}
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                    <div class="text-sm text-orange-600 font-medium mb-1">Highest Price</div>
                    <div class="text-2xl font-bold text-orange-900">
                        ₹{{ number_format($rankedProducts->last()->base_price ?? 0, 2) }}
                    </div>
                </div>
            </div>

            <!-- Your Position -->
            @if($myProducts->isNotEmpty())
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="font-semibold text-blue-900 mb-3">
                    <i class="fas fa-user-chart mr-2"></i>Your Position Analysis
                </h3>
                @foreach($myProducts as $myProduct)
                    @php
                        $myRankedProduct = $rankedProducts->firstWhere('id', $myProduct->id);
                        $totalCompetitors = $rankedProducts->count();
                    @endphp
                    @if($myRankedProduct)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-blue-800">
                                You're ranked <span class="font-bold text-xl">#{{ $myRankedProduct->rank }}</span> out of {{ $totalCompetitors }} distributors
                            </p>
                            @if($myRankedProduct->rank === 1)
                                <p class="text-sm text-green-600 font-medium mt-1">
                                    🎉 Congratulations! You have the lowest price!
                                </p>
                            @elseif($myRankedProduct->rank <= 3)
                                <p class="text-sm text-blue-600 font-medium mt-1">
                                    👍 Great! You're in the top 3 most competitive prices.
                                </p>
                            @else
                                @php
                                    $cheapestPrice = $rankedProducts->first()->base_price;
                                    $difference = $myProduct->base_price - $cheapestPrice;
                                @endphp
                                <p class="text-sm text-orange-600 font-medium mt-1">
                                    💡 Lower your price by ₹{{ number_format($difference + 0.01, 2) }} to become the cheapest!
                                </p>
                            @endif
                        </div>
                        <a href="{{ route('distributor.products.edit', $myProduct) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="fas fa-edit mr-2"></i>Adjust Price
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection