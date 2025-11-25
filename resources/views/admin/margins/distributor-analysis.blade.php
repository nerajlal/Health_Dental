@extends('layouts.app')

@section('title', 'Distributor Profit Analysis')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Distributor Profit Analysis</h1>
        <p class="mt-2 text-gray-600">Performance breakdown by distributor partners</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('admin.margin') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Transaction Details
            </a>
            <a href="{{ route('admin.margin.products') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Products
            </a>
            <a href="{{ route('admin.margin.distributors') }}" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Distributors
            </a>
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
        $totalRevenue = $distributorStats->sum('total_revenue');
        $totalCost = $distributorStats->sum('total_cost');
        $totalProfit = $distributorStats->sum('total_profit');
        $avgMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;
        $totalOrders = $distributorStats->sum('total_orders');
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Active Distributors</p>
            <p class="text-3xl font-bold text-gray-900">{{ $distributorStats->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Total Revenue</p>
            <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Total Profit</p>
            <p class="text-3xl font-bold text-blue-600">₹{{ number_format($totalProfit, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Total Orders</p>
            <p class="text-3xl font-bold text-purple-600">{{ number_format($totalOrders) }}</p>
        </div>
    </div>

    <!-- Top Distributors -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                <i class="fas fa-medal text-blue-500 mr-2"></i>
                Top 3 Distributors by Revenue
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($distributorStats->take(3) as $index => $dist)
                <div class="border-2 {{ $index === 0 ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200' }} rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-4">
                        @if($index === 0)
                        <i class="fas fa-crown text-4xl text-yellow-500"></i>
                        @elseif($index === 1)
                        <i class="fas fa-award text-4xl text-gray-400"></i>
                        @else
                        <i class="fas fa-medal text-4xl text-orange-600"></i>
                        @endif
                        <span class="text-4xl font-bold {{ $index === 0 ? 'text-yellow-600' : 'text-gray-400' }}">
                            #{{ $index + 1 }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $dist->name }}</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Revenue:</span>
                            <span class="font-bold text-green-600">₹{{ number_format($dist->total_revenue, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Profit:</span>
                            <span class="font-bold text-blue-600">₹{{ number_format($dist->total_profit, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Margin:</span>
                            <span class="font-bold text-purple-600">{{ number_format($dist->profit_margin, 1) }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Orders:</span>
                            <span class="font-semibold">{{ $dist->total_orders }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Distributor Performance Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">All Distributors Performance</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distributor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Products Sold</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Orders</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Revenue</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Cost</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Profit</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Margin %</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($distributorStats as $index => $dist)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                {{ $index < 3 ? 'bg-blue-100 text-blue-800 font-bold' : 'bg-gray-100 text-gray-600' }}">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ $dist->name }}</div>
                            <div class="text-xs text-gray-500">{{ $dist->business_registration ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="text-gray-900">{{ $dist->email }}</div>
                            <div class="text-xs text-gray-500">{{ $dist->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                            {{ $dist->products_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            {{ number_format($dist->total_quantity) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                            {{ $dist->total_orders }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                            ₹{{ number_format($dist->total_revenue, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600">
                            ₹{{ number_format($dist->total_cost, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                            ₹{{ number_format($dist->total_profit, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $dist->profit_margin >= 30 ? 'bg-green-100 text-green-800' : 
                                   ($dist->profit_margin >= 20 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ number_format($dist->profit_margin, 1) }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-store-slash text-4xl mb-4"></i>
                            <p>No distributor data found for the selected period.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($distributorStats->count() > 0)
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-sm text-gray-900">TOTAL</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($distributorStats->sum('total_quantity')) }}</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">{{ $totalOrders }}</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">₹{{ number_format($totalRevenue, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-right text-red-600">₹{{ number_format($totalCost, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-right text-green-600">₹{{ number_format($totalProfit, 2) }}</td>
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

    <!-- Performance Chart Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Distributor Revenue Distribution</h3>
            <div class="space-y-3">
                @foreach($distributorStats->take(5) as $dist)
                @php
                    $percentage = $totalRevenue > 0 ? ($dist->total_revenue / $totalRevenue) * 100 : 0;
                @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $dist->name }}</span>
                        <span class="font-semibold">₹{{ number_format($dist->total_revenue, 0) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500">{{ number_format($percentage, 1) }}% of total</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Profit Margin Comparison</h3>
            <div class="space-y-3">
                @foreach($distributorStats->sortByDesc('profit_margin')->take(5) as $dist)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $dist->name }}</span>
                        <span class="font-semibold">{{ number_format($dist->profit_margin, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ min($dist->profit_margin, 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection