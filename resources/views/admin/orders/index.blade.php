@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="section-title text-4xl mb-2">Order Management</h1>
        <p class="text-lg text-gray-600">Comprehensive order tracking and management</p>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg mb-6 flex items-center">
        <i class="fas fa-check-circle text-2xl mr-3"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('info'))
    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 px-6 py-4 rounded-lg mb-6 flex items-center">
        <i class="fas fa-info-circle text-2xl mr-3"></i>
        <span>{{ session('info') }}</span>
    </div>
    @endif

    <!-- PENDING CLINIC ORDERS -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                <i class="fas fa-clock text-yellow-500 mr-2"></i>
                Pending Clinic Orders
                @if($pendingOrders->count() > 0)
                <span class="ml-2 px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full font-semibold">{{ $pendingOrders->count() }}</span>
                @endif
            </h2>
            @if($pendingOrders->count() > 0)
            <a href="{{ route('admin.orders.pending') }}" class="btn-primary bg-green-600 hover:bg-green-700">
                <i class="fas fa-check-double mr-2"></i>Approve All Orders
            </a>
            @endif
        </div>

        <div class="card overflow-hidden">
            @if($pendingOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-yellow-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Clinic</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendingOrders as $order)
                        <tr class="hover:bg-yellow-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">
                                    #{{ $order->id }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $order->clinic->name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->clinic->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $order->items->count() }} items</div>
                                <div class="text-xs text-gray-500">
                                    @foreach($order->items->groupBy('product.distributor_id') as $distributorId => $items)
                                        {{ $items->first()->product->distributor->name }}: {{ $items->count() }} items
                                        @if(!$loop->last)<br>@endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg font-bold gradient-text" style="font-family: 'Playfair Display', serif;">₹{{ number_format($order->total_amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                                    View Details <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-12 text-center">
                <i class="fas fa-check-circle text-green-500 text-5xl mb-3"></i>
                <p class="text-gray-600 text-lg font-medium">No pending orders</p>
                <p class="text-gray-400 text-sm">All orders have been approved</p>
            </div>
            @endif
        </div>
    </div>

    <!-- ORDERS IN PROGRESS -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                <i class="fas fa-sync text-blue-500 mr-2"></i>
                Orders in Progress
                <span class="ml-2 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-semibold">{{ $processingOrders->total() }}</span>
            </h2>
        </div>

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Clinic</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Items Progress</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($processingOrders as $order)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">
                                    #{{ $order->id }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $order->clinic->name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->clinic->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $order->shipped_items_count }} of {{ $order->total_items_count }} shipped
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $order->total_items_count > 0 ? ($order->shipped_items_count / $order->total_items_count * 100) : 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg font-bold gradient-text" style="font-family: 'Playfair Display', serif;">₹{{ number_format($order->total_amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                                    Manage <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-box-open text-gray-300 text-5xl mb-3"></i>
                                <p class="text-lg">No orders in progress</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $processingOrders->links() }}
        </div>
    </div>

    <!-- SHIPPED ORDERS -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                <i class="fas fa-shipping-fast text-indigo-500 mr-2"></i>
                Shipped Orders (Ready for Delivery)
                <span class="ml-2 px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full font-semibold">{{ $shippedOrders->total() }}</span>
            </h2>
        </div>

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Clinic</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Shipped Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($shippedOrders as $order)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">
                                    #{{ $order->id }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $order->clinic->name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->clinic->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $order->items->count() }} items</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg font-bold gradient-text" style="font-family: 'Playfair Display', serif;">₹{{ number_format($order->total_amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->updated_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit" onclick="return confirm('Mark this order as delivered?')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition mr-2">
                                        <i class="fas fa-check mr-1"></i>Mark Delivered
                                    </button>
                                </form>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">
                                    View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-truck text-gray-300 text-5xl mb-3"></i>
                                <p class="text-lg">No shipped orders</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $shippedOrders->links() }}
        </div>
    </div>
</div>
@endsection