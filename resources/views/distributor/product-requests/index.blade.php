@extends('layouts.app')

@section('title', 'Product Requests')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Product Requests</h1>
        <p class="mt-2 text-gray-600">Requests assigned to you by admin</p>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Info Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <div class="flex">
            <i class="fas fa-info-circle text-blue-600 text-2xl mr-4 flex-shrink-0"></i>
            <div>
                <h3 class="text-lg font-medium text-blue-900">About Product Requests</h3>
                <p class="mt-2 text-sm text-blue-700">
                    These are product requests from clinics that have been approved by the admin. 
                    Any distributor can fulfill these requests by creating the requested product in their catalog.
                </p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    @php
        $pendingCount = $requests->where('status', 'approved')->count();
        $fulfilledCount = $requests->where('status', 'fulfilled')->count();
    @endphp
    <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600 font-medium">Pending Action</p>
                    <p class="text-3xl font-bold text-yellow-900">{{ $pendingCount }}</p>
                </div>
                <i class="fas fa-clock text-yellow-300 text-4xl"></i>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 font-medium">Fulfilled</p>
                    <p class="text-3xl font-bold text-green-900">{{ $fulfilledCount }}</p>
                </div>
                <i class="fas fa-check-circle text-green-300 text-4xl"></i>
            </div>
        </div>
    </div> -->

    <!-- Requests Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clinic</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urgency</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $request->product_name }}</div>
                            @if($request->company)
                            <div class="text-sm text-gray-500">{{ $request->company }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $request->clinic->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $request->category ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $request->estimated_quantity ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($request->urgency == 'very_urgent') bg-red-100 text-red-800
                                @elseif($request->urgency == 'urgent') bg-orange-100 text-orange-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $request->urgency)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($request->status == 'fulfilled') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $request->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('distributor.product-requests.show', $request) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-4"></i>
                            <p class="text-lg">No product requests assigned to you yet</p>
                            <p class="text-sm text-gray-400 mt-2">Requests will appear here when admin assigns them to you</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $requests->links() }}
    </div>
</div>
@endsection