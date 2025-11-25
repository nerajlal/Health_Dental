@extends('layouts.app')

@section('title', 'Product Request Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('distributor.product-requests.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Back to Requests
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Product Request #{{ $productRequest->id }}</h1>
                <p class="mt-2 text-gray-600">Submitted on {{ $productRequest->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                @if($productRequest->status == 'fulfilled') bg-green-100 text-green-800
                @else bg-yellow-100 text-yellow-800
                @endif">
                {{ ucfirst($productRequest->status) }}
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Product Details</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Product Name</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $productRequest->product_name }}</p>
                    </div>

                    @if($productRequest->company)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Company/Brand</label>
                        <p class="text-gray-900">{{ $productRequest->company }}</p>
                    </div>
                    @endif

                    @if($productRequest->category)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Category</label>
                        <p class="text-gray-900">{{ $productRequest->category }}</p>
                    </div>
                    @endif

                    @if($productRequest->description)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-gray-900">{{ $productRequest->description }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        @if($productRequest->estimated_quantity)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Estimated Quantity</label>
                            <p class="text-gray-900 font-semibold">{{ $productRequest->estimated_quantity }}</p>
                        </div>
                        @endif

                        @if($productRequest->expected_price)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Expected Price</label>
                            <p class="text-gray-900 font-semibold">${{ number_format($productRequest->expected_price, 2) }}</p>
                        </div>
                        @endif
                    </div>

                    @if($productRequest->reference_link)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Reference Link</label>
                        <a href="{{ $productRequest->reference_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all">
                            {{ $productRequest->reference_link }} <i class="fas fa-external-link-alt ml-1"></i>
                        </a>
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium text-gray-500">Urgency</label>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                            @if($productRequest->urgency == 'very_urgent') bg-red-100 text-red-800
                            @elseif($productRequest->urgency == 'urgent') bg-orange-100 text-orange-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $productRequest->urgency)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Admin Notes -->
            @if($productRequest->admin_notes)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Admin Notes
                </h3>
                <p class="text-blue-800">{{ $productRequest->admin_notes }}</p>
            </div>
            @endif

            <!-- Actions -->
            @if($productRequest->status == 'approved')
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Fulfill Request</h2>
                <p class="text-gray-600 mb-6">You can fulfill this request by creating a new product in your catalog.</p>
                
                <a href="{{ route('distributor.product-requests.create-product', $productRequest) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                    <i class="fas fa-plus-circle mr-2"></i>Create Product & Fulfill Request
                </a>
            </div>
            @endif

            @if($productRequest->status == 'fulfilled')
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-green-900">Request Fulfilled</h3>
                        <p class="text-sm text-green-700 mt-1">This request has been marked as fulfilled. The product is now available in the catalog.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Clinic Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Clinic Information</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium text-gray-500">Clinic Name</label>
                        <p class="text-sm font-medium text-gray-900">{{ $productRequest->clinic->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Email</label>
                        <p class="text-sm text-gray-900">{{ $productRequest->clinic->email }}</p>
                    </div>
                    @if($productRequest->clinic->phone)
                    <div>
                        <label class="text-xs font-medium text-gray-500">Phone</label>
                        <p class="text-sm text-gray-900">{{ $productRequest->clinic->phone }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-blue-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Request Created</p>
                            <p class="text-xs text-gray-500">{{ $productRequest->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    @if($productRequest->assigned_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-check text-green-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Assigned to You</p>
                            <p class="text-xs text-gray-500">{{ $productRequest->assigned_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($productRequest->status == 'fulfilled')
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-double text-purple-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Fulfilled</p>
                            <p class="text-xs text-gray-500">{{ $productRequest->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection