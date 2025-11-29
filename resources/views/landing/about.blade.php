@extends('layouts.landing')

@section('title', 'About Us - DentalChain')

@section('content')
<!-- Hero -->
<section class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">About DentalChain</h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Revolutionizing dental supply procurement through collective purchasing power
        </p>
    </div>
</section>

<!-- Our Mission -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="section-title text-3xl md:text-4xl font-bold mb-6">Our Mission</h2>
                <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                    DentalChain was founded on a simple yet powerful idea: dental clinics shouldn't have to pay premium prices for essential supplies just because they order individually.
                </p>
                <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                    By aggregating orders from multiple clinics and creating bulk purchase volumes, we negotiate significantly better prices with distributors. The result? 30-40% cost savings passed directly to dental clinics.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed">
                    We're not just a platform – we're your purchasing partner, committed to reducing your operational costs while maintaining the highest quality standards.
                </p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-blue-100 rounded-3xl transform rotate-3"></div>
                <img src="https://www.medicalkemei.com/wp-content/uploads/2022/10/Different-Medical-Consumables.png"
                    alt="Dental Supplies" class="rounded-3xl shadow-xl relative z-10 object-cover w-full h-full">
            </div>
        </div>
    </div>
</section>

<!-- How We Operate -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">How We Operate</h2>
            <p class="text-xl text-gray-600">A transparent, efficient process</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- For Clinics -->
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">For Dental Clinics</h3>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">1</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2 text-lg">Browse & Order</h4>
                            <p class="text-gray-600">Access thousands of verified dental products through our platform. Place orders just like you would with any supplier.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">2</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2 text-lg">We Aggregate</h4>
                            <p class="text-gray-600">Your order joins others from clinics across the region, creating bulk purchase volume.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">3</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2 text-lg">Bulk Pricing Applied</h4>
                            <p class="text-gray-600">Receive products at bulk rates – 30-40% lower than individual purchase prices.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">4</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2 text-lg">Direct Delivery</h4>
                            <p class="text-gray-600">Products are delivered directly to your clinic. Track your order every step of the way.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- For Distributors -->
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">For Distributors</h3>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">1</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2 text-lg">List Products</h4>
                            <p class="text-gray-600">Add your dental supply catalog to our platform. Set your base prices.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">2</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2 text-lg">Admin Approval</h4>
                            <p class="text-gray-600">Our team verifies product quality and pricing before they go live.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">3</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2 text-lg">Receive Bulk Orders</h4>
                            <p class="text-gray-600">Get consolidated orders from multiple clinics, making logistics efficient.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold">4</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2 text-lg">Fulfill & Deliver</h4>
                            <p class="text-gray-600">Process orders efficiently with better margins on larger volumes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">The DentalChain Advantage</h2>
            <p class="text-xl text-gray-600">What sets us apart</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="feature-card p-8 rounded-2xl bg-white">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-percent text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Guaranteed Savings</h3>
                <p class="text-gray-600">30-40% cost reduction on supplies through bulk purchasing power. No hidden fees.</p>
            </div>

            <div class="feature-card p-8 rounded-2xl bg-white">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check-double text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Quality Verified</h3>
                <p class="text-gray-600">Every product and distributor is thoroughly vetted by our admin team before approval.</p>
            </div>

            <div class="feature-card p-8 rounded-2xl bg-white">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Community Driven</h3>
                <p class="text-gray-600">Join 500+ dental clinics benefiting from collective purchasing power.</p>
            </div>

            <div class="feature-card p-8 rounded-2xl bg-white">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Secure Platform</h3>
                <p class="text-gray-600">Bank-level security with encrypted transactions and data protection.</p>
            </div>

            <div class="feature-card p-8 rounded-2xl bg-white">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Dedicated Support</h3>
                <p class="text-gray-600">Our team is here to help with any questions or issues you may have.</p>
            </div>

            <div class="feature-card p-8 rounded-2xl bg-white">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Transparent Pricing</h3>
                <p class="text-gray-600">See exactly what you're paying and how much you're saving on every order.</p>
            </div>
        </div>
    </div>
</section>

<!-- Impact Numbers -->
<section class="py-20 gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">Our Impact</h2>
            <p class="text-xl text-blue-100">Making a difference in dental procurement</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center p-6">
                <div class="text-5xl md:text-6xl font-bold mb-2" style="font-family: 'Playfair Display', serif;">500+</div>
                <div class="text-xl text-blue-100">Active Clinics</div>
            </div>
            <div class="text-center p-6">
                <div class="text-5xl md:text-6xl font-bold mb-2" style="font-family: 'Playfair Display', serif;">50+</div>
                <div class="text-xl text-blue-100">Verified Distributors</div>
            </div>
            <div class="text-center p-6">
                <div class="text-5xl md:text-6xl font-bold mb-2" style="font-family: 'Playfair Display', serif;">₹2L+</div>
                <div class="text-xl text-blue-100">Total Savings</div>
            </div>
            <div class="text-center p-6">
                <div class="text-5xl md:text-6xl font-bold mb-2" style="font-family: 'Playfair Display', serif;">10K+</div>
                <div class="text-xl text-blue-100">Products Available</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">Join the Movement</h2>
        <p class="text-xl text-gray-600 mb-8">Start saving on dental supplies today</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('landing.contact') }}" class="btn-primary">
                Get In Touch
            </a>
            <a href="{{ route('login') }}" class="btn-secondary">
                Login to Your Account
            </a>
        </div>
    </div>
</section>
@endsection