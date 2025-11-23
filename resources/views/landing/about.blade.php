@extends('layouts.landing')

@section('title', 'About Us - DentalChain')

@section('content')
<!-- Hero -->
<section class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">About DentalChain</h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Revolutionizing dental supply procurement through collective purchasing power
        </p>
    </div>
</section>

<!-- Our Story -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Our Mission</h2>
                <p class="text-lg text-gray-600 mb-4">
                    DentalChain was founded on a simple idea: dental clinics shouldn't have to pay premium prices for essential supplies just because they order individually.
                </p>
                <p class="text-lg text-gray-600 mb-4">
                    By aggregating orders from multiple clinics and creating bulk purchase volumes, we negotiate significantly better prices with distributors. The result? 30-40% cost savings passed directly to dental clinics.
                </p>
                <p class="text-lg text-gray-600">
                    We're not just a platform – we're your purchasing partner, committed to reducing your operational costs while maintaining the highest quality standards.
                </p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-blue-200 rounded-3xl transform rotate-3"></div>
                <!-- <img src="https://images.unsplash.com/photo-1606811971618-4486d9eef2d2?w=600&h=400&fit=crop" alt="Our Mission" class="rounded-3xl shadow-xl relative z-10"> -->
                <img src="https://www.medicalkemei.com/wp-content/uploads/2022/10/Different-Medical-Consumables.png"
                    alt="Dental Disposables" class="rounded-3xl shadow-xl relative z-10 object-cover w-full h-full">
            </div>
        </div>
    </div>
</section>

<!-- How We Work -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How We Operate</h2>
            <p class="text-xl text-gray-600">A transparent, efficient process</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
            <div class="order-2 md:order-1">
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-200 rounded-3xl transform -rotate-3"></div>
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&h=400&fit=crop" alt="For Clinics" class="rounded-3xl shadow-xl relative z-10">
                </div>
            </div>
            <div class="order-1 md:order-2">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">For Dental Clinics</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">1</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Browse & Order</h4>
                            <p class="text-gray-600">Access thousands of verified dental products through our platform. Place orders just like you would with any supplier.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">2</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">We Aggregate</h4>
                            <p class="text-gray-600">Your order joins others from clinics across the region, creating bulk purchase volume.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">3</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Bulk Pricing Applied</h4>
                            <p class="text-gray-600">Receive products at bulk rates – 30-40% lower than individual purchase prices.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">4</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Direct Delivery</h4>
                            <p class="text-gray-600">Products are delivered directly to your clinic. Track your order every step of the way.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">For Distributors</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">1</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">List Products</h4>
                            <p class="text-gray-600">Add your dental supply catalog to our platform. Set your base prices.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">2</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Admin Approval</h4>
                            <p class="text-gray-600">Our team verifies product quality and pricing before they go live.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">3</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Receive Bulk Orders</h4>
                            <p class="text-gray-600">Get consolidated orders from multiple clinics, making logistics efficient.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">4</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Fulfill & Deliver</h4>
                            <p class="text-gray-600">Process orders efficiently with better margins on larger volumes.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-200 rounded-3xl transform rotate-3"></div>
                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600&h=400&fit=crop" alt="For Distributors" class="rounded-3xl shadow-xl relative z-10">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Advantage -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">The DentalChain Advantage</h2>
            <p class="text-xl text-gray-600">Why we're different</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="feature-card p-8 border border-gray-200 rounded-2xl bg-gray-50">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-percent text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Guaranteed Savings</h3>
                <p class="text-gray-600">30-40% cost reduction on supplies through bulk purchasing power. No hidden fees.</p>
            </div>

            <div class="feature-card p-8 border border-gray-200 rounded-2xl bg-gray-50">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check-double text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Quality Verified</h3>
                <p class="text-gray-600">Every product and distributor is thoroughly vetted by our admin team before approval.</p>
            </div>

            <div class="feature-card p-8 border border-gray-200 rounded-2xl bg-gray-50">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Community Driven</h3>
                <p class="text-gray-600">Join 500+ dental clinics benefiting from collective purchasing power.</p>
            </div>

            <div class="feature-card p-8 border border-gray-200 rounded-2xl bg-gray-50">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Secure Platform</h3>
                <p class="text-gray-600">Bank-level security with encrypted transactions and data protection.</p>
            </div>

            <div class="feature-card p-8 border border-gray-200 rounded-2xl bg-gray-50">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Dedicated Support</h3>
                <p class="text-gray-600">Our team is here to help with any questions or issues you may have.</p>
            </div>

            <div class="feature-card p-8 border border-gray-200 rounded-2xl bg-gray-50">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Transparent Pricing</h3>
                <p class="text-gray-600">See exactly what you're paying and how much you're saving on every order.</p>
            </div>
        </div>
    </div>
</section>

<!-- Numbers -->
<section class="py-20 gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Impact</h2>
            <p class="text-xl text-blue-100">Making a difference in dental procurement</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-bold mb-2">500+</div>
                <div class="text-xl text-blue-100">Active Clinics</div>
            </div>
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-bold mb-2">50+</div>
                <div class="text-xl text-blue-100">Verified Distributors</div>
            </div>
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-bold mb-2">₹2L+</div>
                <div class="text-xl text-blue-100">Total Savings</div>
            </div>
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-bold mb-2">10K+</div>
                <div class="text-xl text-blue-100">Products Available</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Join the Movement</h2>
        <p class="text-xl text-gray-600 mb-8">Start saving on dental supplies today</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('landing.contact') }}" class="gradient-bg text-white px-8 py-4 rounded-lg font-bold text-lg hover:opacity-90 transition">
                Get In Touch
            </a>
            <a href="{{ route('login') }}" class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-50 transition">
                Login to Your Account
            </a>
        </div>
    </div>
</section>
@endsection