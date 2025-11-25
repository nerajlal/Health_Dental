@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
            <p class="mt-2 text-gray-600">Track orders and mark items as shipped to admin</p>
        </div>
        <a href="{{ route('distributor.orders.bulk') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-boxes mr-2"></i>Bulk Orders
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Order Status Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('distributor.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="packed" {{ request('status') == 'packed' ? 'selected' : '' }}>Packed</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </div> -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Shipment Status</label>
                <select name="shipped_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All</option>
                    <option value="shipped" {{ request('shipped_status') == 'shipped' ? 'selected' : '' }}>Shipped to Admin</option>
                    <option value="not_shipped" {{ request('shipped_status') == 'not_shipped' ? 'selected' : '' }}>Not Shipped</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Your Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Your Earning</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipment Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orderItems as $item)
                @php
                    $distributorEarning = $item->quantity * $item->product->base_price;
                @endphp
                <tr class="{{ $item->shipped_to_admin ? 'bg-green-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-blue-600">#{{ $item->order->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-10 h-10 rounded mr-3">
                            @else
                            <div class="w-10 h-10 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                <i class="fas fa-tooth text-gray-400"></i>
                            </div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                <div class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $item->quantity }}</div>
                        <div class="text-xs text-gray-500">{{ $item->product->unit }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">₹{{ number_format($item->product->base_price, 2) }}</div>
                        <div class="text-xs text-gray-500">per {{ $item->product->unit }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-green-600">₹{{ number_format($distributorEarning, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($item->order->status == 'delivered') bg-green-100 text-green-800
                            @elseif($item->order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($item->order->status == 'packed') bg-purple-100 text-purple-800
                            @elseif($item->order->status == 'shipped') bg-indigo-100 text-indigo-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($item->order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->shipped_to_admin)
                            <div class="flex flex-col">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mb-1">
                                    <i class="fas fa-check-circle mr-1"></i> Shipped
                                </span>
                                <span class="text-xs text-gray-500">{{ $item->shipped_at->format('M d, Y') }}</span>
                            </div>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i> Pending
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $item->order->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $item->order->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if(!$item->shipped_to_admin && in_array($item->order->status, ['processing', 'packed']))
                            <form action="{{ route('distributor.order-items.mark-shipped', $item) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium">
                                    <i class="fas fa-shipping-fast mr-1"></i>Mark as Shipped
                                </button>
                            </form>
                        @elseif($item->shipped_to_admin && $item->order->status != 'delivered')
                            <form action="{{ route('distributor.order-items.mark-not-shipped', $item) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Unmark this shipment?')" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-xs font-medium">
                                    <i class="fas fa-undo mr-1"></i>Unmark
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                        <p class="text-gray-500 text-lg">No orders found</p>
                        <p class="text-gray-400 text-sm">Orders will appear here after admin approval</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($orderItems->count() > 0)
            <tfoot class="bg-gray-50 font-bold">
                <tr>
                    <td colspan="4" class="px-6 py-4 text-sm text-gray-900 text-right">TOTAL EARNINGS ON THIS PAGE:</td>
                    <td class="px-6 py-4 text-sm text-green-600">
                        ₹{{ number_format($orderItems->sum(fn($item) => $item->quantity * $item->product->base_price), 2) }}
                    </td>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    <div class="mt-6">
        {{ $orderItems->links() }}
    </div>

    <!-- Summary Stats -->
    @if($orderItems->count() > 0)
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 font-medium">Total Order Items</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $orderItems->total() }}</p>
                </div>
                <i class="fas fa-box text-blue-300 text-3xl"></i>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 font-medium">Shipped to Admin</p>
                    <p class="text-2xl font-bold text-green-900">{{ $orderItems->where('shipped_to_admin', true)->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-green-300 text-3xl"></i>
            </div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600 font-medium">Pending Shipment</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $orderItems->where('shipped_to_admin', false)->count() }}</p>
                </div>
                <i class="fas fa-clock text-yellow-300 text-3xl"></i>
            </div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 font-medium">Total Earnings (Page)</p>
                    <p class="text-2xl font-bold text-purple-900">
                        ₹{{ number_format($orderItems->sum(fn($item) => $item->quantity * $item->product->base_price), 2) }}
                    </p>
                </div>
                <i class="fas fa-dollar-sign text-purple-300 text-3xl"></i>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection