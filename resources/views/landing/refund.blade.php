@extends('layouts.landing')

@section('title', 'Refund Policy - DentalChain')

@section('content')
<section class="py-20 bg-gradient-to-br from-green-50 to-teal-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-teal-600 rounded-full mb-6">
                <i class="fas fa-undo-alt text-white text-3xl"></i>
            </div>
            <h1 class="section-title text-4xl md:text-5xl font-bold mb-4">Refund Policy</h1>
            <p class="text-gray-600 text-lg">Last updated: {{ date('F d, Y') }}</p>
            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Your satisfaction is our priority. Learn about our refund process.</p>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Eligible for Refunds -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-green-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Eligible for Refunds</h2>
                </div>
                <div class="space-y-4">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-box-open text-green-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-green-900">Defective Products</p>
                                <p class="text-sm text-gray-700">Items received damaged or defective</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exchange-alt text-green-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-green-900">Wrong Items</p>
                                <p class="text-sm text-gray-700">Products don't match your order</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-question-circle text-green-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-green-900">Missing Items</p>
                                <p class="text-sm text-gray-700">Items missing from shipment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Non-Refundable -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-red-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Non-Refundable</h2>
                </div>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                        <span>Used or opened products (unless defective)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                        <span>Custom or special-order items</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                        <span>Perishable goods past expiration</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                        <span>Items damaged due to misuse</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                        <span>Orders cancelled after shipment</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Refund Process -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-lg p-8 text-white mb-8">
            <h2 class="text-3xl font-bold mb-6 flex items-center">
                <i class="fas fa-list-ol mr-4"></i>
                Refund Process
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white bg-opacity-10 p-6 rounded-lg backdrop-blur-sm">
                    <div class="text-4xl font-bold mb-2">1</div>
                    <p class="font-semibold mb-2">Submit Request</p>
                    <p class="text-sm text-blue-100">File refund request with documentation</p>
                </div>
                <div class="bg-white bg-opacity-10 p-6 rounded-lg backdrop-blur-sm">
                    <div class="text-4xl font-bold mb-2">2</div>
                    <p class="font-semibold mb-2">Review</p>
                    <p class="text-sm text-blue-100">We review within 2-3 business days</p>
                </div>
                <div class="bg-white bg-opacity-10 p-6 rounded-lg backdrop-blur-sm">
                    <div class="text-4xl font-bold mb-2">3</div>
                    <p class="font-semibold mb-2">Processing</p>
                    <p class="text-sm text-blue-100">Refund processed within 5-7 days</p>
                </div>
            </div>
        </div>

        <!-- Timeline & Shipping -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-yellow-500">
                <div class="flex items-center mb-6">
                    <i class="fas fa-clock text-yellow-600 text-2xl mr-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900">Timeline</h2>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                            <span class="font-bold text-yellow-600">7</span>
                        </div>
                        <div>
                            <p class="font-semibold">Days to Report</p>
                            <p class="text-sm text-gray-600">After receiving order</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                            <span class="font-bold text-yellow-600">2-3</span>
                        </div>
                        <div>
                            <p class="font-semibold">Days Review</p>
                            <p class="text-sm text-gray-600">Request processing time</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                            <span class="font-bold text-yellow-600">5-7</span>
                        </div>
                        <div>
                            <p class="font-semibold">Days Processing</p>
                            <p class="text-sm text-gray-600">Refund completion</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-purple-500">
                <div class="flex items-center mb-6">
                    <i class="fas fa-shipping-fast text-purple-600 text-2xl mr-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900">Return Shipping</h2>
                </div>
                <div class="space-y-4">
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="font-semibold text-purple-900 mb-2">Defective/Incorrect Items</p>
                        <p class="text-sm text-gray-700">We provide prepaid return label at no cost</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="font-semibold text-purple-900 mb-2">Other Returns</p>
                        <p class="text-sm text-gray-700">Return shipping costs are buyer's responsibility</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-lg p-8 text-white">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-headset mr-3 text-green-400"></i>
                Refund Support
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center">
                    <i class="fas fa-envelope text-green-400 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-400">Email</p>
                        <p class="font-semibold">{{ config('contact.emails.refunds') }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-phone text-green-400 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-400">Phone</p>
                        <p class="font-semibold">{{ config('contact.contact.phone') }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-clock text-green-400 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-400">Hours</p>
                        <p class="font-semibold">{{ config('contact.hours') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-12 text-center">
            <a href="{{ route('landing.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-lg font-semibold hover:shadow-xl transition-all hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
        </div>
    </div>
</section>
@endsection
