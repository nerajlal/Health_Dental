@extends('layouts.landing')

@section('title', 'FAQ - Frequently Asked Questions | DentalChain')

@section('content')
<section class="py-20 bg-gradient-to-br from-orange-50 to-yellow-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-500 to-yellow-600 rounded-full mb-6">
                <i class="fas fa-question-circle text-white text-3xl"></i>
            </div>
            <h1 class="section-title text-4xl md:text-5xl font-bold mb-4">Frequently Asked Questions</h1>
            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Find quick answers to common questions about DentalChain</p>
        </div>

        <!-- General Questions -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                General Questions
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                        What is DentalChain?
                    </h3>
                    <p class="text-gray-700">
                        A B2B platform connecting dental clinics with verified distributors for bulk purchasing at discounted prices. We aggregate orders to negotiate better prices.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                        How much can I save?
                    </h3>
                    <p class="text-gray-700">
                        On average, clinics save 30-40% compared to traditional purchasing. Savings vary by product and order size.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                        Minimum order requirement?
                    </h3>
                    <p class="text-gray-700">
                        No! We aggregate orders from multiple clinics, so you can order any quantity and still get bulk pricing.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                        How do I join?
                    </h3>
                    <p class="text-gray-700">
                        Click "Partner With Us" in navigation, select your role (Clinic/Distributor), and fill out the registration form.
                    </p>
                </div>
            </div>
        </div>

        <!-- For Clinics -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-clinic-medical text-green-600 mr-3"></i>
                For Dental Clinics
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="text-4xl mb-4">⏱️</div>
                    <h3 class="text-xl font-bold mb-3">Order Approval</h3>
                    <p class="text-green-100">Most orders approved within 24-48 hours. Distributors ship within 3-5 business days.</p>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="text-4xl mb-4">💳</div>
                    <h3 class="text-xl font-bold mb-3">Payment Methods</h3>
                    <p class="text-purple-100">Credit cards, debit cards, bank transfers, and net banking. Terms vary by distributor.</p>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="text-xl font-bold mb-3">Order Tracking</h3>
                    <p class="text-blue-100">Yes! Receive tracking info via email and monitor status through your dashboard.</p>
                </div>
            </div>
        </div>

        <!-- For Distributors -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-truck text-purple-600 mr-3"></i>
                For Distributors
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-purple-500">
                    <div class="flex items-start mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user-plus text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">How to become a distributor?</h3>
                            <p class="text-gray-700">Click "Partner With Us," select "Distributor," and complete the application. We verify all distributors for quality.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-purple-500">
                    <div class="flex items-start mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Any fees to join?</h3>
                            <p class="text-gray-700">No upfront fees. We charge a small platform fee on completed transactions to maintain services.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-purple-500">
                    <div class="flex items-start mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-tags text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">How do I set prices?</h3>
                            <p class="text-gray-700">You set base prices, we add transparent admin margin. See competitor prices in real-time to stay competitive.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-purple-500">
                    <div class="flex items-start mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Competitive pricing?</h3>
                            <p class="text-gray-700">Our platform shows real-time competitor prices, helping you stay competitive and win more orders.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders & Shipping -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-shipping-fast text-orange-600 mr-3"></i>
                Orders & Shipping
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-orange-50 rounded-xl p-6 border-2 border-orange-200">
                    <i class="fas fa-truck text-orange-600 text-3xl mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Shipping Time</h3>
                    <p class="text-gray-700">Typically 5-10 business days after order approval, varies by location and distributor.</p>
                </div>

                <div class="bg-red-50 rounded-xl p-6 border-2 border-red-200">
                    <i class="fas fa-box-open text-red-600 text-3xl mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Damaged Items</h3>
                    <p class="text-gray-700">Contact us immediately with photos. We'll resolve through replacement or refund.</p>
                </div>

                <div class="bg-yellow-50 rounded-xl p-6 border-2 border-yellow-200">
                    <i class="fas fa-ban text-yellow-600 text-3xl mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Cancel Order</h3>
                    <p class="text-gray-700">Possible before approval or shipping. Contact support for assistance once shipped.</p>
                </div>
            </div>
        </div>

        <!-- Still Have Questions -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-lg p-12 text-white text-center">
            <i class="fas fa-headset text-6xl mb-6"></i>
            <h3 class="text-3xl font-bold mb-4">Still Have Questions?</h3>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">We're here to help! Contact our support team for personalized assistance.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('landing.contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 rounded-lg font-semibold hover:shadow-xl transition-all hover:scale-105">
                    <i class="fas fa-envelope mr-2"></i>Contact Us
                </a>
                <a href="{{ route('landing.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-all">
                    <i class="fas fa-home mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
