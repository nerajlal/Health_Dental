@extends('layouts.app')

@section('title', 'Pending Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Pending Orders - Bulk Approval</h1>
        <p class="mt-2 text-gray-600">Review and approve all pending orders to create bulk orders for distributors</p>
    </div>

    @if($pendingOrders->count() > 0)
    <!-- Summary Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-blue-900">
                    {{ $pendingOrders->count() }} Pending Orders
                </h2>
                <p class="text-blue-700 mt-1">Total Value: ${{ number_format($pendingOrders->sum('total_amount'), 2) }}</p>
            </div>
            <form action="{{ route('admin.orders.approve-all') }}" method="POST" onsubmit="return confirm('Are you sure you want to approve all pending orders? This will create bulk orders for distributors.')">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium text-lg">
                    <i class="fas fa-check-double mr-2"></i>Approve All Orders
                </button>
            </form>
        </div>
    </div>

    <!-- Orders Grouped by Distributor -->
    <div class="space-y-6">
        @foreach($groupedByDistributor as $distributorId => $data)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $data['distributor']->name }}
                    </h3>
                    <span class="text-sm text-gray-600 mt-1 sm:mt-0">
                        {{ count($data['items']) }} orders • ${{ number_format(collect($data['items'])->sum(function($item) { return $item['item']->quantity * $item['item']->price; }), 2) }}
                    </span>
                </div>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left text-xs font-medium text-gray-500 uppercase pb-2">Order ID</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase pb-2">Clinic</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase pb-2">Product</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase pb-2">Quantity</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase pb-2">Price</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase pb-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($data['items'] as $orderData)
                        <tr>
                            <td class="py-3 text-sm">
                                <a href="{{ route('admin.orders.show', $orderData['order']) }}" class="text-blue-600 hover:text-blue-900">
                                    #{{ $orderData['order']->id }}
                                </a>
                            </td>
                            <td class="py-3 text-sm text-gray-900">{{ $orderData['order']->clinic->name }}</td>
                            <td class="py-3 text-sm text-gray-900">{{ $orderData['item']->product->name }}</td>
                            <td class="py-3 text-sm text-gray-900">{{ $orderData['item']->quantity }}</td>
                            <td class="py-3 text-sm text-gray-900">${{ number_format($orderData['item']->price, 2) }}</td>
                            <td class="py-3 text-sm font-medium text-gray-900">${{ number_format($orderData['item']->quantity * $orderData['item']->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Approval Info -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-900">What happens when you approve?</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>All pending orders will be marked as "Processing"</li>
                        <li>Bulk orders will be created for each distributor</li>
                        <li>Distributors will receive notifications to ship products to admin warehouse</li>
                        <li>You can then repack and ship to individual clinics</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- No Pending Orders -->
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">No Pending Orders</h2>
        <p class="text-gray-600 mb-6">All orders have been processed</p>
        <a href="{{ route('admin.orders.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            View All Orders
        </a>
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to All Orders
        </a>
    </div>
</div>
@endsection