@extends('layouts.landing')

@section('title', 'Our Story - DentalChain')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg text-white py-24 md:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight" style="font-family: 'Playfair Display', serif;">
            Our Story
        </h1>
        <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto">
            A journey to transform dental supply procurement through innovation and collaboration
        </p>
    </div>
</section>

<!-- The Beginning -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="section-title text-3xl md:text-4xl font-bold mb-6">The Beginning</h2>
                <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                    DentalChain was born from a simple observation: dental clinics across the country were paying premium prices for the same supplies, simply because they were ordering individually.
                </p>
                <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                    Our founders, experienced professionals in both healthcare and supply chain management, recognized that this wasn't just inefficient—it was unsustainable for small and medium-sized dental practices.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed">
                    The vision was clear: create a platform that would level the playing field, giving every dental clinic access to the same bulk pricing advantages that large hospital chains enjoy.
                </p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-blue-100 rounded-3xl transform -rotate-3"></div>
                <div class="relative z-10 bg-white p-8 rounded-3xl shadow-xl">
                    <div class="text-center">
                        <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-lightbulb text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                        <p class="text-gray-600 italic">
                            "To make quality dental supplies accessible and affordable for every clinic, regardless of size."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Challenge -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">The Challenge We Identified</h2>
            <p class="text-xl text-gray-600">Understanding the problem was the first step</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-chart-line text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Rising Costs</h3>
                <p class="text-gray-600">Dental supply costs were increasing year over year, putting pressure on clinic margins and profitability.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-balance-scale text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Unfair Pricing</h3>
                <p class="text-gray-600">Small clinics paid significantly more than large institutions for the exact same products.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-puzzle-piece text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Fragmented Market</h3>
                <p class="text-gray-600">No unified platform existed to connect clinics and leverage their collective purchasing power.</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Solution -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <div class="relative">
                    <div class="absolute inset-0 bg-green-100 rounded-3xl transform rotate-3"></div>
                    <div class="relative z-10 bg-white p-8 rounded-3xl shadow-xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">The DentalChain Solution</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <p class="text-gray-600">Aggregate orders from multiple clinics</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <p class="text-gray-600">Negotiate bulk pricing with distributors</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <p class="text-gray-600">Pass savings directly to clinics</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <p class="text-gray-600">Maintain quality and compliance standards</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <h2 class="section-title text-3xl md:text-4xl font-bold mb-6">How We Solved It</h2>
                <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                    We built a technology platform that brings together dental clinics and distributors in a transparent, efficient marketplace.
                </p>
                <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                    By aggregating orders from hundreds of clinics, we create the bulk purchasing volume that commands better pricing. But we don't stop there—we verify every distributor and product to ensure quality standards are maintained.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed">
                    The result? Clinics save 30-40% on supplies without compromising on quality, and distributors benefit from larger, more predictable orders.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Growth Journey -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">Our Growth Journey</h2>
            <p class="text-xl text-gray-600">Key milestones in our story</p>
        </div>

        <div class="relative">
            <!-- Timeline line -->
            <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-blue-200"></div>

            <div class="space-y-12">
                <!-- Milestone 1 -->
                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="md:text-right">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 inline-block">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Platform Launch</h3>
                            <p class="text-gray-600">Launched with 50 clinics and 10 distributors, proving the concept works.</p>
                        </div>
                    </div>
                    <div class="md:text-left">
                        <div class="inline-block px-6 py-3 gradient-bg text-white rounded-full font-bold">
                            Year 1
                        </div>
                    </div>
                </div>

                <!-- Milestone 2 -->
                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="md:text-right order-2 md:order-1">
                        <div class="inline-block px-6 py-3 gradient-bg text-white rounded-full font-bold">
                            Year 2
                        </div>
                    </div>
                    <div class="md:text-left order-1 md:order-2">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 inline-block">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Rapid Expansion</h3>
                            <p class="text-gray-600">Grew to 200+ clinics, achieving ₹50L+ in total savings for our community.</p>
                        </div>
                    </div>
                </div>

                <!-- Milestone 3 -->
                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="md:text-right">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 inline-block">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Market Leader</h3>
                            <p class="text-gray-600">Now serving 500+ clinics with 50+ verified distributors and ₹2L+ in savings.</p>
                        </div>
                    </div>
                    <div class="md:text-left">
                        <div class="inline-block px-6 py-3 gradient-bg text-white rounded-full font-bold">
                            Today
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Looking Forward -->
<section class="py-20 gradient-bg text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6" style="font-family: 'Playfair Display', serif;">Looking Forward</h2>
        <p class="text-xl text-blue-100 mb-8 leading-relaxed">
            Our journey is just beginning. We're committed to continuously improving our platform, expanding our network, and finding new ways to deliver value to dental clinics and distributors alike.
        </p>
        <p class="text-lg text-blue-50 mb-8">
            We envision a future where every dental clinic, regardless of size or location, has access to fair pricing and quality supplies. Together, we're building that future.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('landing.contact') }}" class="btn-secondary bg-white text-blue-900 border-white hover:bg-blue-50">
                Join Our Journey
            </a>
            <a href="{{ route('landing.about') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-900 transition">
                Learn More About Us
            </a>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">Our Core Values</h2>
            <p class="text-xl text-gray-600">The principles that guide everything we do</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Transparency</h3>
                <p class="text-gray-600">Open, honest pricing and operations</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Quality</h3>
                <p class="text-gray-600">Never compromise on product standards</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Community</h3>
                <p class="text-gray-600">Stronger together through collaboration</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-rocket text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Innovation</h3>
                <p class="text-gray-600">Continuously improving and evolving</p>
            </div>
        </div>
    </div>
</section>
@endsection
