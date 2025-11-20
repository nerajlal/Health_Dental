@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Analytics Dashboard</h1>
        <p class="mt-2 text-gray-600">Comprehensive reports and statistics</p>
    </div>

    <!-- Monthly Revenue Chart -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Monthly Revenue (Current Year)</h2>
        <div class="h-64 flex items-end space-x-2">
            @foreach($monthly_revenue as $month)
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition" 
                     style="height: {{ ($month->revenue / $monthly_revenue->max('revenue')) * 100 }}%"
                     title="${{ number_format($month->revenue, 2) }}">
                </div>
                <span class="text-xs text-gray-600 mt-2">{{ date('M', mktime(0, 0, 0, $month->month, 1)) }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Product Performance -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Product Performance</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distributor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Sold</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Avg Price</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($product_performance->take(10) as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $product->distributor->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $product->total_quantity ?? 0 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${{ number_format($product->total_revenue ?? 0, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($product->base_price, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Clinics -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Top Clinics by Spending</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($clinic_orders->take(5) as $clinic)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $clinic->name }}</p>
                            <p class="text-sm text-gray-500">{{ $clinic->orders_count }} orders</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">${{ number_format($clinic->total_spent ?? 0, 2) }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-4">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Distributor Performance -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Distributor Performance</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($distributor_performance as $distributor)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $distributor->name }}</p>
                            <p class="text-sm text-gray-500">{{ $distributor->products_count }} products</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">
                                {{ $distributor->products->sum(function($p) { return $p->total_orders ?? 0; }) }} total orders
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-4">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection