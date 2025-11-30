@extends('layouts.landing')

@section('title', 'DentalChain - Save Up to 40% on Dental Supplies Through Bulk Purchasing')

@section('content')
<!-- Hero Section -->
<section class="relative gradient-bg text-white py-24 md:py-32 overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-full mb-6 animate-fade-in-down">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm font-semibold">Trusted by 500+ Dental Clinics</span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight animate-fade-in-up" style="font-family: 'Playfair Display', serif;">
                    Professional Dental Supply 
                    <span class="block mt-2 bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 via-pink-300 to-purple-300">
                        <span id="typed-text"></span><span class="animate-blink">|</span>
                    </span>
                </h1>
                
                <p class="text-xl md:text-2xl mb-4 text-blue-100 animate-fade-in-up animation-delay-200">
                    💰 Save 30-40% Through Collective Purchasing Power
                </p>
                
                <p class="text-lg mb-8 text-blue-50 max-w-2xl mx-auto lg:mx-0 animate-fade-in-up animation-delay-400">
                    Join hundreds of dental clinics leveraging bulk purchasing to reduce operational costs while maintaining premium quality standards.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fade-in-up animation-delay-600">
                    <a href="{{ route('landing.about') }}" class="group relative inline-flex items-center justify-center px-8 py-4 bg-white text-blue-900 rounded-lg font-semibold text-lg overflow-hidden transition-all hover:scale-105 hover:shadow-2xl">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-rocket mr-2"></i>
                            Learn How It Works
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
                    </a>
                    <a href="{{ route('landing.contact') }}" class="group relative inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white rounded-lg font-semibold text-lg overflow-hidden transition-all hover:scale-105">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-phone-alt mr-2"></i>
                            Get In Touch
                        </span>
                        <div class="absolute inset-0 bg-white transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
                        <span class="absolute inset-0 flex items-center justify-center text-blue-900 opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-phone-alt mr-2"></i>
                            Get In Touch
                        </span>
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="mt-12 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-sm text-blue-100 animate-fade-in-up animation-delay-800">
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-green-300 mr-2"></i>
                        <span>Verified Suppliers</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-lock text-green-300 mr-2"></i>
                        <span>Secure Payments</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-truck text-green-300 mr-2"></i>
                        <span>Fast Delivery</span>
                    </div>
                </div>
            </div>

            <!-- Right Content - Interactive Cards -->
            <div class="hidden lg:block animate-fade-in-left">
                <!-- Main Card -->
                <div class="relative">
                    <!-- Floating Card 1 - Cost Comparison -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-8 border border-white border-opacity-20 shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold">Cost Comparison</h3>
                            <div class="w-12 h-12 bg-green-400 bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-green-300 text-xl"></i>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-4 bg-white bg-opacity-10 rounded-lg backdrop-blur-sm transform hover:translate-x-2 transition-transform">
                                <span class="font-medium">Traditional Purchase:</span>
                                <span class="text-2xl font-bold text-red-300">₹1,000</span>
                            </div>
                            
                            <div class="text-center text-3xl animate-bounce-slow">
                                <i class="fas fa-arrow-down text-yellow-300"></i>
                            </div>
                            
                            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-500 to-emerald-500 bg-opacity-90 rounded-lg shadow-lg transform hover:translate-x-2 transition-transform">
                                <span class="font-medium">With DentalChain:</span>
                                <span class="text-2xl font-bold">₹600-700</span>
                            </div>
                            
                            <div class="text-center p-4 bg-yellow-400 bg-opacity-20 rounded-lg backdrop-blur-sm">
                                <div class="text-2xl font-bold text-yellow-300 animate-pulse">
                                    💰 Save 30-40%!
                                </div>
                                <div class="text-sm text-yellow-200 mt-1">That's ₹300-400 per item!</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -top-6 -right-6 bg-gradient-to-r from-pink-500 to-purple-500 text-white px-6 py-3 rounded-full shadow-2xl transform rotate-12 hover:rotate-0 transition-transform animate-float">
                        <div class="text-center">
                            <div class="text-2xl font-bold">35%</div>
                            <div class="text-xs">Avg. Savings</div>
                        </div>
                    </div>

                    <!-- Floating Icon -->
                    <div class="absolute -bottom-4 -left-4 bg-blue-400 bg-opacity-30 backdrop-blur-sm p-4 rounded-2xl shadow-xl animate-float animation-delay-2000">
                        <i class="fas fa-tooth text-white text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-white text-2xl opacity-50"></i>
    </div>
</section>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fade-in-left {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }
    
    .animate-fade-in-down {
        animation: fade-in-down 0.6s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out;
    }
    
    .animate-fade-in-left {
        animation: fade-in-left 0.8s ease-out;
    }
    
    .animate-blink {
        animation: blink 1s infinite;
    }
    
    .animation-delay-200 {
        animation-delay: 0.2s;
    }
    
    .animation-delay-400 {
        animation-delay: 0.4s;
    }
    
    .animation-delay-600 {
        animation-delay: 0.6s;
    }
    
    .animation-delay-800 {
        animation-delay: 0.8s;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>

<script>
    // Typing animation
    const words = ['Solutions', 'Made Simple', 'At Best Prices', 'You Can Trust'];
    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    const typedTextElement = document.getElementById('typed-text');
    
    function type() {
        const currentWord = words[wordIndex];
        
        if (isDeleting) {
            typedTextElement.textContent = currentWord.substring(0, charIndex - 1);
            charIndex--;
        } else {
            typedTextElement.textContent = currentWord.substring(0, charIndex + 1);
            charIndex++;
        }
        
        if (!isDeleting && charIndex === currentWord.length) {
            setTimeout(() => isDeleting = true, 2000);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            wordIndex = (wordIndex + 1) % words.length;
        }
        
        const typingSpeed = isDeleting ? 50 : 100;
        setTimeout(type, typingSpeed);
    }
    
    // Start typing animation
    setTimeout(type, 1000);
</script>


<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-6">
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2" style="font-family: 'Playfair Display', serif;">500+</div>
                <div class="text-gray-600 font-medium">Dental Clinics</div>
            </div>
            <div class="p-6">
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2" style="font-family: 'Playfair Display', serif;">50+</div>
                <div class="text-gray-600 font-medium">Verified Distributors</div>
            </div>
            <div class="p-6">
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2" style="font-family: 'Playfair Display', serif;">35%</div>
                <div class="text-gray-600 font-medium">Average Savings</div>
            </div>
            <div class="p-6">
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2" style="font-family: 'Playfair Display', serif;">₹2L+</div>
                <div class="text-gray-600 font-medium">Total Savings</div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">How We Save You Money</h2>
            <p class="text-xl text-gray-600">A simple, transparent process</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clinic-medical text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">1. Clinics Order</h3>
                <p class="text-gray-600">Multiple dental clinics place individual orders through our secure platform</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-layer-group text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">2. We Aggregate</h3>
                <p class="text-gray-600">Orders are combined into one large bulk purchase for maximum leverage</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-handshake text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">3. Bulk Pricing</h3>
                <p class="text-gray-600">Distributors offer 30-40% lower prices for consolidated bulk orders</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
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
            <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">Why Choose DentalChain?</h2>
            <p class="text-xl text-gray-600">The professional choice for dental supply procurement</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Benefit 1 -->
            <div class="feature-card bg-white p-8 rounded-2xl">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-piggy-bank text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Significant Cost Savings</h3>
                <p class="text-gray-600 mb-4">Save 30-40% compared to traditional purchasing. That's thousands saved annually per clinic.</p>
                <ul class="space-y-2 text-gray-600">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>No minimum order required</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Bulk prices for everyone</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Transparent pricing</li>
                </ul>
            </div>

            <!-- Benefit 2 -->
            <div class="feature-card bg-white p-8 rounded-2xl">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Verified Quality</h3>
                <p class="text-gray-600 mb-4">All distributors and products are thoroughly verified by our admin team.</p>
                <ul class="space-y-2 text-gray-600">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Quality guaranteed products</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Trusted distributors only</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Full compliance</li>
                </ul>
            </div>

            <!-- Benefit 3 -->
            <div class="feature-card bg-white p-8 rounded-2xl">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Simple & Efficient</h3>
                <p class="text-gray-600 mb-4">Streamlined ordering process with quick approval and delivery timelines.</p>
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
            <h2 class="text-3xl md:text-4xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">What Our Clinics Say</h2>
            <p class="text-xl text-blue-100">Real savings, real testimonials</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white bg-opacity-10 backdrop-blur-lg p-8 rounded-2xl border border-white border-opacity-20">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-blue-50 mb-6 italic">"We're saving over ₹3,000 monthly on supplies. The bulk purchasing power really works. Highly recommended!"</p>
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

            <div class="bg-white bg-opacity-10 backdrop-blur-lg p-8 rounded-2xl border border-white border-opacity-20">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-blue-50 mb-6 italic">"The platform is simple to use and the savings are substantial. We reduced our supply costs by 35%."</p>
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

            <div class="bg-white bg-opacity-10 backdrop-blur-lg p-8 rounded-2xl border border-white border-opacity-20">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-blue-50 mb-6 italic">"As a distributor, the bulk orders help us plan better and pass on better prices. Win-win situation."</p>
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
        <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">Ready to Start Saving?</h2>
        <p class="text-xl text-gray-600 mb-8">Join hundreds of dental clinics already saving thousands monthly</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('landing.contact') }}" class="btn-primary">
                Contact Us Today
            </a>
            <a href="{{ route('landing.about') }}" class="btn-secondary">
                Learn More
            </a>
        </div>
    </div>
</section>
@endsection