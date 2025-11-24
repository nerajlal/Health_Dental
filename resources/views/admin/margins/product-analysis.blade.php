@extends('layouts.app')

@section('title', 'Product Profit Analysis')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Product Profit Analysis</h1>
        <p class="mt-2 text-gray-600">Performance breakdown by individual products</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('admin.margin') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Transaction Details
            </a>
            <a href="{{ route('admin.margin.products') }}" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Products
            </a>
            <a href="{{ route('admin.margin.distributors') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Distributors
            </a>
        </nav>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Distributor</label>
                <select name="distributor_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Distributors</option>
                    @foreach($distributors as $dist)
                    <option value="{{ $dist->id }}" {{ request('distributor_id') == $dist->id ? 'selected' : '' }}>
                        {{ $dist->name }}
                    </option>
                    @endforeach
                </select>
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
        $totalRevenue = $productStats->sum('total_revenue');
        $totalCost = $productStats->sum('total_cost');
        $totalProfit = $productStats->sum('total_profit');
        $avgMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Total Products</p>
            <p class="text-3xl font-bold text-gray-900">{{ $productStats->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Total Revenue</p>
            <p class="text-3xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Total Profit</p>
            <p class="text-3xl font-bold text-blue-600">${{ number_format($totalProfit, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Avg Margin</p>
            <p class="text-3xl font-bold text-purple-600">{{ number_format($avgMargin, 1) }}%</p>
        </div>
    </div>

    <!-- Top Performing Products -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                Top 5 Most Profitable Products
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach($productStats->take(5) as $index => $stat)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-2xl font-bold text-gray-400">#{{ $index + 1 }}</span>
                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-800">
                            ${{ number_format($stat->total_profit, 0) }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1 truncate" title="{{ $stat->product->name }}">
                        {{ $stat->product->name }}
                    </h3>
                    <p class="text-xs text-gray-500 mb-2">{{ $stat->product->distributor->name }}</p>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600">{{ $stat->total_quantity }} sold</span>
                        <span class="font-semibold text-green-600">{{ number_format($stat->profit_margin, 1) }}%</span>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distributor</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Quantity Sold</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Orders</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Base Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Admin Margin</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Revenue</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Cost</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Profit</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Margin %</th>
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
                            <div class="text-gray-500">{{ $stat->product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $stat->product->distributor->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            {{ number_format($stat->total_quantity) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                            {{ $stat->order_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                            ${{ number_format($stat->product->base_price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                            <span class="text-blue-600 font-medium">${{ number_format($stat->product->admin_margin, 2) }}</span>
                            <div class="text-xs text-gray-500">Total: ${{ number_format($stat->admin_margin_total, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            ${{ number_format($stat->total_revenue, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600">
                            ${{ number_format($stat->total_cost, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                            ${{ number_format($stat->total_profit, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $stat->profit_margin >= 30 ? 'bg-green-100 text-green-800' : 
                                   ($stat->profit_margin >= 20 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ number_format($stat->profit_margin, 1) }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-4"></i>
                            <p>No product data found for the selected period.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($productStats->count() > 0)
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-sm text-gray-900">TOTAL</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($productStats->sum('total_quantity')) }}</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">{{ $productStats->sum('order_count') }}</td>
                        <td class="px-6 py-4 text-sm text-right">-</td>
                        <td class="px-6 py-4 text-sm text-right text-blue-600">${{ number_format($productStats->sum('admin_margin_total'), 2) }}</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">${{ number_format($totalRevenue, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-right text-red-600">${{ number_format($totalCost, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-right text-green-600">${{ number_format($totalProfit, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ number_format($avgMargin, 1) }}%
                            </span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection