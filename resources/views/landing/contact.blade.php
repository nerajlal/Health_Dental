@extends('layouts.landing')

@section('title', 'Contact Us - DentalChain')

@section('content')
<!-- Hero -->
<section class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">Get In Touch</h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Have questions? Want to partner with us? We're here to help.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="section-title text-3xl font-bold mb-6">Send Us a Message</h2>
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                            <input type="text" id="first_name" name="first_name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="clinic_name" class="block text-sm font-semibold text-gray-700 mb-2">Clinic/Company Name</label>
                        <input type="text" id="clinic_name" name="clinic_name"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="inquiry_type" class="block text-sm font-semibold text-gray-700 mb-2">I am a *</label>
                        <select id="inquiry_type" name="inquiry_type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Select...</option>
                            <option value="clinic">Dental Clinic</option>
                            <option value="distributor">Distributor</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                        <textarea id="message" name="message" rows="6" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"></textarea>
                    </div>

                    <button type="submit" class="w-full btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i>Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div>
                <h2 class="section-title text-3xl font-bold mb-6">Contact Information</h2>
                
                <div class="space-y-8">
                    <!-- Address -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Office Address</h3>
                            <p class="text-gray-600">{{ config('contact.contact.address') }}</p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-phone text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Phone</h3>
                            <p class="text-gray-600 mb-2">
                                <a href="tel:{{ str_replace([' ', '(', ')', '-'], '', config('contact.contact.phone')) }}" class="hover:text-blue-600 transition">{{ config('contact.contact.phone') }}</a>
                            </p>
                            <p class="text-sm text-gray-500">{{ config('contact.hours') }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Email</h3>
                            <p class="text-gray-600 mb-1">
                                <a href="mailto:{{ config('contact.contact.email') }}" class="hover:text-blue-600 transition">{{ config('contact.contact.email') }}</a>
                            </p>
                            <!-- <p class="text-gray-600">
                                <a href="mailto:{{ config('contact.emails.support') }}" class="hover:text-blue-600 transition">{{ config('contact.emails.support') }}</a>
                            </p> -->
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mt-12">
                    <h3 class="font-bold text-gray-900 mb-4 text-lg">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="{{ config('contact.social.facebook') }}" class="w-12 h-12 border-2 border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:border-blue-600 hover:text-blue-600 transition">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="{{ config('contact.social.twitter') }}" class="w-12 h-12 border-2 border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:border-blue-600 hover:text-blue-600 transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="{{ config('contact.social.linkedin') }}" class="w-12 h-12 border-2 border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:border-blue-600 hover:text-blue-600 transition">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                        <a href="{{ config('contact.social.instagram') }}" class="w-12 h-12 border-2 border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:border-blue-600 hover:text-blue-600 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Map Placeholder -->
                <div class="mt-12">
                    <div class="bg-gray-200 rounded-2xl overflow-hidden shadow-lg" style="height: 300px;">
                        <iframe 
                            src="{{ config('contact.contact.map_url') }}" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">Frequently Asked Questions</h2>
            <p class="text-xl text-gray-600">Quick answers to common questions</p>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-2 text-lg">How much can I really save?</h3>
                <p class="text-gray-600">On average, our clinics save 30-40% on their dental supply costs through bulk purchasing. Savings vary by product category.</p>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-2 text-lg">Is there a minimum order requirement?</h3>
                <p class="text-gray-600">No! Order as much or as little as you need. You still benefit from bulk pricing because we aggregate orders from multiple clinics.</p>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-2 text-lg">How do I become a partner distributor?</h3>
                <p class="text-gray-600">Fill out the contact form above or use the "Partner with us" menu and our team will reach out to discuss partnership opportunities.</p>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-2 text-lg">Are all products quality verified?</h3>
                <p class="text-gray-600">Yes, every product and distributor goes through our rigorous admin approval process before being listed on the platform.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="section-title text-3xl md:text-4xl font-bold mb-4">Ready to Start Saving?</h2>
        <p class="text-xl text-gray-600 mb-8">Already have an account? Log in to start ordering.</p>
        <a href="{{ route('login') }}" class="btn-primary">
            <i class="fas fa-sign-in-alt mr-2"></i>Login to Your Account
        </a>
    </div>
</section>
@endsection