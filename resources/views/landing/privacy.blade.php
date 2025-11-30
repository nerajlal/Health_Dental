@extends('layouts.landing')

@section('title', 'Privacy Policy - DentalChain')

@section('content')
<section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-6">
                <i class="fas fa-shield-alt text-white text-3xl"></i>
            </div>
            <h1 class="section-title text-4xl md:text-5xl font-bold mb-4">Privacy Policy</h1>
            <p class="text-gray-600 text-lg">Last updated: {{ date('F d, Y') }}</p>
            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Your privacy is important to us. Learn how we collect, use, and protect your information.</p>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Card 1: Information We Collect -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-blue-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-database text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Information We Collect</h2>
                </div>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <span>Name, email, phone, and business information</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <span>Account credentials and profile details</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <span>Order history and transaction data</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <span>Communication preferences and feedback</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <span>Payment info (via secure third-party providers)</span>
                    </li>
                </ul>
            </div>

            <!-- Card 2: How We Use Your Information -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-purple-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-cogs text-purple-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">How We Use It</h2>
                </div>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-purple-500 mt-1 mr-3"></i>
                        <span>Process and fulfill your orders</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-purple-500 mt-1 mr-3"></i>
                        <span>Communicate about your account and orders</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-purple-500 mt-1 mr-3"></i>
                        <span>Improve our platform and services</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-purple-500 mt-1 mr-3"></i>
                        <span>Send marketing (with your consent)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-purple-500 mt-1 mr-3"></i>
                        <span>Detect and prevent fraud</span>
                    </li>
                </ul>
            </div>

            <!-- Card 3: Information Sharing -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-orange-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-share-alt text-orange-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Information Sharing</h2>
                </div>
                <div class="space-y-4 text-gray-700">
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <p class="font-semibold text-orange-900 mb-2">Distributors</p>
                        <p class="text-sm">Share necessary info to fulfill orders</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <p class="font-semibold text-orange-900 mb-2">Service Providers</p>
                        <p class="text-sm">Third-party companies helping us operate</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <p class="font-semibold text-orange-900 mb-2">Legal Requirements</p>
                        <p class="text-sm">When required by law</p>
                    </div>
                </div>
            </div>

            <!-- Card 4: Your Rights -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border-t-4 border-green-500">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-user-shield text-green-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Your Rights</h2>
                </div>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                        <span>Access and receive a copy of your data</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                        <span>Correct inaccurate information</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                        <span>Request deletion of your data</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                        <span>Object to data processing</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                        <span>Data portability</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Full Width Cards -->
        <div class="space-y-6">
            <!-- Data Security -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-lg p-8 text-white">
                <div class="flex items-center mb-4">
                    <i class="fas fa-lock text-3xl mr-4"></i>
                    <h2 class="text-3xl font-bold">Data Security</h2>
                </div>
                <p class="text-blue-100 text-lg">
                    We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet is 100% secure.
                </p>
            </div>

            <!-- Cookies -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-yellow-500">
                <div class="flex items-center mb-4">
                    <i class="fas fa-cookie-bite text-yellow-600 text-3xl mr-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900">Cookies & Tracking</h2>
                </div>
                <p class="text-gray-700">
                    We use cookies and similar tracking technologies to improve your experience, analyze usage, and deliver personalized content. You can control cookies through your browser settings.
                </p>
            </div>

            <!-- Contact -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-lg p-8 text-white">
                <h2 class="text-2xl font-bold mb-6 flex items-center">
                    <i class="fas fa-envelope mr-3 text-blue-400"></i>
                    Contact Us
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-blue-400 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-400">Email</p>
                            <p class="font-semibold">{{ config('contact.emails.privacy') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-blue-400 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-400">Phone</p>
                            <p class="font-semibold">{{ config('contact.contact.phone') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-400 text-xl mr-3"></i>
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
            <a href="{{ route('landing.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-xl transition-all hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
        </div>
    </div>
</section>
@endsection
