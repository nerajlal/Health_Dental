@extends('layouts.app')

@section('title', 'Custom Pricing')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Custom Pricing: {{ $product->name }}</h1>
        <p class="mt-2 text-gray-600">Set special prices for specific clinics</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Add Custom Pricing Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Add Custom Pricing</h2>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-900">About Custom Pricing</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Base Price: <strong>${{ number_format($product->base_price, 2) }}</strong></p>
                            <p class="mt-1">Default margin: 15%</p>
                            <p class="mt-1">Default clinic price: <strong>${{ number_format($product->base_price * 1.15, 2) }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.products.store-custom-pricing', $product) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="clinic_id" class="block text-sm font-medium text-gray-700 mb-2">Select Clinic *</label>
                        <select name="clinic_id" id="clinic_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choose a clinic...</option>
                            @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                            @endforeach
                        </select>
                        @error('clinic_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="custom_price" class="block text-sm font-medium text-gray-700 mb-2">Custom Price *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500 font-medium">$</span>
                            <input type="number" name="custom_price" id="custom_price" step="0.01" min="0" required
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Set a custom price for this specific clinic</p>
                        @error('custom_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Set Custom Price
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Custom Pricing -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Current Custom Pricing</h2>
            
            <div class="space-y-3">
                @forelse($customPricing as $pricing)
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition">
                    <div class="flex-1 w-full sm:w-auto">
                        <p class="font-medium text-gray-900">{{ $pricing->clinic->name }}</p>
                        <div class="mt-1 flex flex-col sm:flex-row sm:items-center space-y-1 sm:space-y-0 sm:space-x-4">
                            <span class="text-sm text-gray-500">Custom: <strong class="text-green-600">${{ number_format($pricing->custom_price, 2) }}</strong></span>
                            <span class="text-sm text-gray-400 hidden sm:inline">•</span>
                            <span class="text-sm text-gray-500">Base: ${{ number_format($product->base_price, 2) }}</span>
                        </div>
                        @if($pricing->custom_price < $product->base_price)
                        <span class="inline-block mt-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">
                            Below base price
                        </span>
                        @endif
                    </div>
                    <form action="{{ route('admin.custom-pricing.destroy', $pricing) }}" method="POST" class="mt-4 sm:mt-0 sm:ml-4 self-end sm:self-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Remove custom pricing for this clinic?')" 
                                class="text-red-600 hover:text-red-800 p-2">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-dollar-sign text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No custom pricing set yet</p>
                    <p class="text-sm text-gray-400 mt-1">All clinics see the default price: ${{ number_format($product->base_price * 1.15, 2) }}</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Products
        </a>
    </div>
</div>
@endsection