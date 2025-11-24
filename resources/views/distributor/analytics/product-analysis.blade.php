@extends('layouts.app')

@section('title', 'Product Performance Analysis')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Product Performance Analysis</h1>
        <p class="mt-2 text-gray-600">See which products are generating the most revenue</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('distributor.analytics') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Overview
            </a>
            <a href="{{ route('distributor.analytics.products') }}" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Product Performance
            </a>
            <!-- <a href="{{ route('distributor.analytics.clinics') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Clinic Analysis
            </a> -->
        </nav>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    @php
        $totalEarnings = $productStats->sum('total_earnings');
        $totalQuantity = $productStats->sum('total_quantity');
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Total Products Sold</p>
            <p class="text-3xl font-bold text-gray-900">{{ $productStats->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Total Quantity</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($totalQuantity) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Total Earnings</p>
            <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalEarnings, 2) }}</p>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                Top 5 Best Selling Products
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach($productStats->take(5) as $index => $stat)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-2xl font-bold text-gray-400">#{{ $index + 1 }}</span>
                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-800">
                            ₹{{ number_format($stat->total_earnings, 0) }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1 truncate" title="{{ $stat->product->name }}">
                        {{ $stat->product->name }}
                    </h3>
                    <p class="text-xs text-gray-500 mb-2">{{ $stat->product->sku }}</p>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600">{{ $stat->total_quantity }} sold</span>
                        <span class="font-semibold text-blue-600">₹{{ number_format($stat->product->base_price, 2) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Product Performance Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">All Products Performance</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Your Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Quantity Sold</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Orders</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Earnings</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($productStats as $index => $stat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                {{ $index < 3 ? 'bg-yellow-100 text-yellow-800 font-bold' : 'bg-gray-100 text-gray-600' }}">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ $stat->product->name }}</div>
                            <div class="text-gray-500 text-xs">SKU: {{ $stat->product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $stat->product->category }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            ₹{{ number_format($stat->product->base_price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            {{ number_format($stat->total_quantity) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                            {{ $stat->order_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                            ₹{{ number_format($stat->total_earnings, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-4 text-gray-300"></i>
                            <p>No product sales data found for the selected period.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($productStats->count() > 0)
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-sm text-gray-900">TOTAL</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($totalQuantity) }}</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">{{ $productStats->sum('order_count') }}</td>
                        <td class="px-6 py-4 text-sm text-right text-green-600">₹{{ number_format($totalEarnings, 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection