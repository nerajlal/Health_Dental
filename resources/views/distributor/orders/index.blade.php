@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
            <p class="mt-2 text-gray-600">Track orders grouped by product and mark items as shipped to admin</p>
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Shipment Status</label>
                <select name="shipped_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All</option>
                    <option value="shipped" {{ request('shipped_status') == 'shipped' ? 'selected' : '' }}>Fully Shipped</option>
                    <option value="not_shipped" {{ request('shipped_status') == 'not_shipped' ? 'selected' : '' }}>Not Shipped</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                @if(request('shipped_status') || request('date_from'))
                <a href="{{ route('distributor.orders.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table - Product Based -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Your Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Earnings</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipment Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latest Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($paginatedProducts as $productGroup)
                    @php
                        $allShipped = $productGroup->shipped_count == $productGroup->total_orders;
                        $noneShipped = $productGroup->pending_count == $productGroup->total_orders;
                    @endphp
                    <tr class="{{ $allShipped ? 'bg-green-50' : '' }}">
                        <!-- Product Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($productGroup->product->image)
                                <img src="{{ asset('storage/' . $productGroup->product->image) }}" 
                                     alt="{{ $productGroup->product->name }}" 
                                     class="w-12 h-12 rounded mr-3 object-cover">
                                @else
                                <div class="w-12 h-12 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-tooth text-gray-400"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $productGroup->product->name }}</div>
                                    <div class="text-xs text-gray-500">SKU: {{ $productGroup->product->sku }}</div>
                                    <!-- <div class="text-xs text-gray-400 mt-1">
                                        <i class="fas fa-clinic-medical mr-1"></i>
                                        {{ $productGroup->clinics->count() }} clinic(s)
                                    </div> -->
                                </div>
                            </div>
                        </td>

                        <!-- Total Orders -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $productGroup->total_orders }} orders</div>
                            <!-- <button onclick="toggleDetails('details-{{ $productGroup->product->id }}')" 
                                    class="text-xs text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </button> -->
                        </td>

                        <!-- Total Quantity -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $productGroup->total_quantity }}</div>
                            <div class="text-xs text-gray-500">{{ $productGroup->product->unit }}</div>
                        </td>

                        <!-- Your Price -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">₹{{ number_format($productGroup->product->base_price, 2) }}</div>
                            <div class="text-xs text-gray-500">per {{ $productGroup->product->unit }}</div>
                        </td>

                        <!-- Total Earnings -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-base font-bold text-green-600">₹{{ number_format($productGroup->total_earning, 2) }}</div>
                        </td>

                        <!-- Shipment Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($allShipped)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> All Shipped
                                </span>
                            @elseif($noneShipped)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> All Pending
                                </span>
                            @else
                                <div class="flex flex-col gap-1">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $productGroup->shipped_count }} Shipped
                                    </span>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $productGroup->pending_count }} Pending
                                    </span>
                                </div>
                            @endif
                        </td>

                        <!-- Latest Order Date -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $productGroup->latest_date->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $productGroup->latest_date->format('h:i A') }}</div>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(!$allShipped)
                                <button onclick="markAllShipped({{ $productGroup->product->id }})" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium">
                                    <i class="fas fa-shipping-fast mr-1"></i>Mark All as Shipped
                                </button>
                            @else
                                <span class="text-xs text-green-600 font-medium">
                                    <i class="fas fa-check mr-1"></i>Complete
                                </span>
                            @endif
                        </td>
                    </tr>

                    <!-- Expandable Details Row -->
                    <tr id="details-{{ $productGroup->product->id }}" class="hidden bg-gray-50">
                        <td colspan="8" class="px-6 py-4">
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <h4 class="font-semibold text-gray-900 mb-3">Order Details for {{ $productGroup->product->name }}</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Order ID</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Clinic</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Quantity</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Earning</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Date</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($productGroup->items as $item)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-blue-600 font-medium">#{{ $item->order->id }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $item->order->clinic->name }}</td>
                                                <td class="px-4 py-2 text-sm font-semibold">{{ $item->quantity }}</td>
                                                <td class="px-4 py-2 text-sm text-green-600 font-bold">
                                                    ${{ number_format($item->quantity * $item->product->base_price, 2) }}
                                                </td>
                                                <td class="px-4 py-2 text-sm">
                                                    @if($item->shipped_to_admin)
                                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                            <i class="fas fa-check mr-1"></i>Shipped
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i>Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-500">
                                                    {{ $item->order->created_at->format('M d') }}
                                                </td>
                                                <td class="px-4 py-2 text-sm">
                                                    @if(!$item->shipped_to_admin)
                                                        <form action="{{ route('distributor.order-items.mark-shipped', $item) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="text-green-600 hover:text-green-800 text-xs font-medium">
                                                                Mark Shipped
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('distributor.order-items.mark-not-shipped', $item) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="text-gray-600 hover:text-gray-800 text-xs font-medium">
                                                                Unmark
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500 text-lg">No orders found</p>
                            <p class="text-gray-400 text-sm">Orders will appear here after admin approval</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($paginatedProducts->count() > 0)
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-sm text-gray-900 text-right">TOTAL EARNINGS ON THIS PAGE:</td>
                        <td class="px-6 py-4 text-sm text-green-600">
                            ₹{{ number_format($paginatedProducts->sum('total_earning'), 2) }}
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $paginatedProducts->appends(request()->query())->links() }}
    </div>

    <!-- Summary Stats -->
    @if($paginatedProducts->count() > 0)
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 font-medium">Total Products</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $paginatedProducts->count() }}</p>
                </div>
                <i class="fas fa-box text-blue-300 text-3xl"></i>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 font-medium">Total Order Items</p>
                    <p class="text-2xl font-bold text-green-900">{{ $allOrderItems->count() }}</p>
                </div>
                <i class="fas fa-shopping-cart text-green-300 text-3xl"></i>
            </div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600 font-medium">Items Shipped</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $allOrderItems->where('shipped_to_admin', true)->count() }}</p>
                </div>
                <i class="fas fa-shipping-fast text-yellow-300 text-3xl"></i>
            </div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 font-medium">Total Earnings</p>
                    <p class="text-2xl font-bold text-purple-900">
                        ₹{{ number_format($allOrderItems->sum(fn($item) => $item->quantity * $item->product->base_price), 2) }}
                    </p>
                </div>
                <i class="fas fa-indian-rupee-sign text-purple-300 text-3xl"></i>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function toggleDetails(id) {
    const element = document.getElementById(id);
    element.classList.toggle('hidden');
}

function markAllShipped(productId) {
    if (!confirm('Mark all pending orders for this product as shipped?')) return;
    
    const forms = document.querySelectorAll(`#details-${productId} form[action*="mark-shipped"]`);
    let completed = 0;
    
    forms.forEach(form => {
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(() => {
            completed++;
            if (completed === forms.length) {
                location.reload();
            }
        });
    });
}
</script>
@endsection