@extends('layouts.landing')

@section('title', 'DentalChain - Save Up to 40% on Dental Supplies Through Bulk Purchasing')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg text-white py-20 md:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Save 30-40% on Dental Supplies
                </h1>
                <p class="text-xl md:text-2xl mb-4 text-blue-100">
                    Through Collective Bulk Purchasing Power
                </p>
                <p class="text-lg mb-8 text-blue-100">
                    We aggregate orders from multiple dental clinics and negotiate better prices with distributors. The savings go directly to you.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('landing.about') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition text-center">
                        Learn How It Works
                    </a>
                    <a href="{{ route('landing.contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition text-center">
                        Get In Touch
                    </a>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-8">
                    <h3 class="text-2xl font-bold mb-6">Cost Comparison</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-white bg-opacity-20 rounded-lg">
                            <span>Direct Purchase:</span>
                            <span class="text-2xl font-bold">₹1000</span>
                        </div>
                        <div class="text-center text-3xl">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-green-500 rounded-lg">
                            <span>With DentalChain:</span>
                            <span class="text-2xl font-bold">₹600-700</span>
                        </div>
                        <div class="text-center text-xl font-bold text-green-300">
                            Save 30-40%!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">500+</div>
                <div class="text-gray-600">Dental Clinics</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">50+</div>
                <div class="text-gray-600">Verified Distributors</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">35%</div>
                <div class="text-gray-600">Average Savings</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">₹2L+</div>
                <div class="text-gray-600">Total Savings</div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How We Save You Money</h2>
            <p class="text-xl text-gray-600">Simple process, maximum savings</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clinic-medical text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">1. Clinics Order</h3>
                <p class="text-gray-600">Multiple dental clinics place their individual orders through our platform</p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-layer-group text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">2. We Aggregate</h3>
                <p class="text-gray-600">We combine all orders into one large bulk purchase</p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">3. Bulk Pricing</h3>
                <p class="text-gray-600">Distributors offer 30-40% lower prices for bulk orders</p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-truck text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">4. You Save</h3>
                <p class="text-gray-600">Products delivered at bulk prices directly to your clinic</p>
            </div>
        </div>
    </div>
</section>

<!-- Benefits -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose DentalChain?</h2>
            <p class="text-xl text-gray-600">The smart way to purchase dental supplies</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Benefit 1 -->
            <div class="feature-card bg-gray-50 p-8 rounded-2xl border border-gray-200">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-piggy-bank text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Massive Cost Savings</h3>
                <p class="text-gray-600 mb-4">Save 30-40% compared to direct purchases. That's thousands of dollars saved annually per clinic.</p>
                <ul class="space-y-2 text-gray-600">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>No minimum order required</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Bulk prices for everyone</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Transparent pricing</li>
                </ul>
            </div>

            <!-- Benefit 2 -->
            <div class="feature-card bg-gray-50 p-8 rounded-2xl border border-gray-200">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Verified Quality</h3>
                <p class="text-gray-600 mb-4">All distributors and products are verified by our admin team before approval.</p>
                <ul class="space-y-2 text-gray-600">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Quality guaranteed products</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Trusted distributors only</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Full compliance</li>
                </ul>
            </div>

            <!-- Benefit 3 -->
            <div class="feature-card bg-gray-50 p-8 rounded-2xl border border-gray-200">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Simple & Fast</h3>
                <p class="text-gray-600 mb-4">Easy ordering process with quick approval and delivery timelines.</p>
                <ul class="space-y-2 text-gray-600">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>User-friendly platform</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Order tracking</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Quick approvals</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">What Our Clinics Say</h2>
            <p class="text-xl text-blue-100">Real savings, real testimonials</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white bg-opacity-10 backdrop-blur-lg p-8 rounded-2xl">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-blue-100 mb-6">"We're saving over ₹3,000 monthly on supplies. The bulk purchasing power really works. Highly recommended!"</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-300 rounded-full flex items-center justify-center mr-4">
                        <span class="text-blue-900 font-bold">DS</span>
                    </div>
                    <div>
                        <div class="font-semibold">Dr. Sarah Johnson</div>
                        <div class="text-sm text-blue-200">SmileCare Dental Clinic</div>
                    </div>
                </div>
            </div>

            <div class="bg-white bg-opacity-10 backdrop-blur-lg p-8 rounded-2xl">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-blue-100 mb-6">"The platform is simple to use and the savings are substantial. We reduced our supply costs by 35%."</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-300 rounded-full flex items-center justify-center mr-4">
                        <span class="text-blue-900 font-bold">MP</span>
                    </div>
                    <div>
                        <div class="font-semibold">Dr. Michael Park</div>
                        <div class="text-sm text-blue-200">BrightSmile Dentistry</div>
                    </div>
                </div>
            </div>

            <div class="bg-white bg-opacity-10 backdrop-blur-lg p-8 rounded-2xl">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-blue-100 mb-6">"As a distributor, the bulk orders help us plan better and pass on better prices. Win-win situation."</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-300 rounded-full flex items-center justify-center mr-4">
                        <span class="text-blue-900 font-bold">RJ</span>
                    </div>
                    <div>
                        <div class="font-semibold">Robert Jones</div>
                        <div class="text-sm text-blue-200">DentalSupply Pro</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Ready to Start Saving?</h2>
        <p class="text-xl text-gray-600 mb-8">Join hundreds of dental clinics already saving thousands monthly</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('landing.contact') }}" class="gradient-bg text-white px-8 py-4 rounded-lg font-bold text-lg hover:opacity-90 transition">
                Contact Us Today
            </a>
            <a href="{{ route('landing.about') }}" class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-50 transition">
                Learn More
            </a>
        </div>
    </div>
</section>
@endsection