@extends('layouts.landing')

@section('title', 'Terms of Service - DentalChain')

@section('content')
<section class="py-20 bg-gradient-to-br from-purple-50 to-pink-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full mb-6">
                <i class="fas fa-file-contract text-white text-3xl"></i>
            </div>
            <h1 class="section-title text-4xl md:text-5xl font-bold mb-4">Terms of Service</h1>
            <p class="text-gray-600 text-lg">Last updated: {{ date('F d, Y') }}</p>
            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Please read these terms carefully before using our platform.</p>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: User Accounts -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-purple-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-user-circle text-purple-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">User Accounts</h2>
                </div>
                <ul class="space-y-3 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check text-purple-500 mt-1 mr-2 text-xs"></i>
                        <span>Be at least 18 years old</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-purple-500 mt-1 mr-2 text-xs"></i>
                        <span>Provide accurate information</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-purple-500 mt-1 mr-2 text-xs"></i>
                        <span>Maintain account security</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-purple-500 mt-1 mr-2 text-xs"></i>
                        <span>Report unauthorized access</span>
                    </li>
                </ul>
            </div>

            <!-- Card 2: For Clinics -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-blue-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clinic-medical text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">For Clinics</h2>
                </div>
                <ul class="space-y-3 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-blue-500 mt-1 mr-2 text-xs"></i>
                        <span>Valid business credentials</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-blue-500 mt-1 mr-2 text-xs"></i>
                        <span>Place orders in good faith</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-blue-500 mt-1 mr-2 text-xs"></i>
                        <span>Make timely payments</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-blue-500 mt-1 mr-2 text-xs"></i>
                        <span>Comply with laws</span>
                    </li>
                </ul>
            </div>

            <!-- Card 3: For Distributors -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-green-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-truck text-green-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">For Distributors</h2>
                </div>
                <ul class="space-y-3 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-green-500 mt-1 mr-2 text-xs"></i>
                        <span>Accurate product info</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-green-500 mt-1 mr-2 text-xs"></i>
                        <span>Maintain inventory</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-green-500 mt-1 mr-2 text-xs"></i>
                        <span>Timely fulfillment</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-green-500 mt-1 mr-2 text-xs"></i>
                        <span>Ensure product quality</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Orders & Payments -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-orange-500">
                <div class="flex items-center mb-6">
                    <i class="fas fa-shopping-cart text-orange-600 text-2xl mr-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900">Orders & Payments</h2>
                </div>
                <div class="space-y-3 text-gray-700">
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <p class="font-semibold text-sm">Admin approval required</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <p class="font-semibold text-sm">Subject to availability</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <p class="font-semibold text-sm">Payment terms as specified</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <p class="font-semibold text-sm">Applicable taxes and fees</p>
                    </div>
                </div>
            </div>

            <!-- Prohibited Activities -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-red-500">
                <div class="flex items-center mb-6">
                    <i class="fas fa-ban text-red-600 text-2xl mr-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900">Prohibited</h2>
                </div>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                        <span>Illegal activities</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                        <span>Violating laws</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                        <span>Infringing IP rights</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                        <span>Fraudulent activities</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Full Width Cards -->
        <div class="space-y-6">
            <!-- Limitation of Liability -->
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl shadow-lg p-8 text-white">
                <div class="flex items-center mb-4">
                    <i class="fas fa-exclamation-triangle text-3xl mr-4"></i>
                    <h2 class="text-3xl font-bold">Limitation of Liability</h2>
                </div>
                <p class="text-purple-100 text-lg">
                    DentalChain acts as an intermediary platform. We are not responsible for the quality, safety, or legality of products listed, the accuracy of listings, or the ability of distributors to complete transactions. Our liability is limited to the maximum extent permitted by law.
                </p>
            </div>

            <!-- Contact -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-lg p-8 text-white">
                <h2 class="text-2xl font-bold mb-6 flex items-center">
                    <i class="fas fa-gavel mr-3 text-purple-400"></i>
                    Legal Contact
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-purple-400 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-400">Email</p>
                            <p class="font-semibold">{{ config('contact.emails.legal') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-purple-400 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-400">Phone</p>
                            <p class="font-semibold">{{ config('contact.contact.phone') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-purple-400 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-400">Address</p>
                            <p class="font-semibold">{{ config('contact.contact.address') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-12 text-center">
            <a href="{{ route('landing.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:shadow-xl transition-all hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
        </div>
    </div>
</section>
@endsection
