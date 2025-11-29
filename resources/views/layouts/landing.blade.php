\u003c!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DentalChain - Bulk Dental Supply Procurement')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: #1a202c;
            line-height: 1.6;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #0f2557 0%, #1e3a8a 50%, #3b82f6 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #0f2557 0%, #1e3a8a 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .feature-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(15, 37, 87, 0.12);
            border-color: #3b82f6;
        }
        
        .mobile-menu {
            transition: max-height 0.3s ease-in-out;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #0f2557 0%, #1e3a8a 50%, #3b82f6 100%);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(15, 37, 87, 0.3);
        }
        
        .btn-secondary {
            border: 2px solid #0f2557;
            color: #0f2557;
            padding: 0.875rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            background: white;
        }
        
        .btn-secondary:hover {
            background: #0f2557;
            color: white;
            transform: translateY(-2px);
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #0f2557;
        }
        
        nav {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #0f2557 0%, #3b82f6 100%);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('landing.index') }}" class="flex items-center">
                        <i class="fas fa-tooth text-3xl gradient-text"></i>
                        <span class="ml-2 text-2xl font-bold gradient-text">DentalChain</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('landing.index') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium">Home</a>
                    <a href="{{ route('landing.about') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium">About</a>
                    <a href="{{ route('landing.story') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium">Our Story</a>
                    <a href="{{ route('landing.contact') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium">Contact</a>
                    <a href="#" onclick="openPartnerModal()" class="nav-link text-gray-700 hover:text-blue-600 font-medium">Partner With Us</a>
                </div>

                <!-- Login Button -->
                <div class="hidden md:flex items-center">
                    <a href="{{ route('login') }}" class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="mobile-menu md:hidden overflow-hidden max-h-0">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                    <a href="{{ route('landing.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md font-medium">Home</a>
                    <a href="{{ route('landing.about') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md font-medium">About</a>
                    <a href="{{ route('landing.story') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md font-medium">Our Story</a>
                    <a href="{{ route('landing.contact') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md font-medium">Contact</a>
                    <a href="#" onclick="openPartnerModal()" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md font-medium">Partner With Us</a>
                    <div class="border-t border-gray-200 pt-4">
                        <a href="{{ route('login') }}" class="block px-3 py-2 gradient-bg text-white rounded-md font-medium text-center">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-tooth text-3xl text-blue-400"></i>
                        <span class="ml-2 text-2xl font-bold">DentalChain</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Reducing costs for dental clinics through collective bulk purchasing power.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin-in text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram text-xl"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('landing.index') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('landing.about') }}" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="{{ route('landing.story') }}" class="text-gray-400 hover:text-white transition">Our Story</a></li>
                        <li><a href="{{ route('landing.contact') }}" class="text-gray-400 hover:text-white transition">Contact</a></li>
                        <li><a href="#" onclick="openPartnerModal()" class="text-gray-400 hover:text-white transition">Partner With Us</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> info@dentalchain.com</li>
                        <li><i class="fas fa-phone mr-2"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> 123 Business Park, City</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 DentalChain. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            if (mobileMenu.style.maxHeight) {
                mobileMenu.style.maxHeight = null;
            } else {
                mobileMenu.style.maxHeight = mobileMenu.scrollHeight + "px";
            }
        });
    </script>

    @stack('scripts')


    <!-- Partner Modal -->
    <div id="partnerModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="gradient-bg text-white p-6 rounded-t-2xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Partner With Us</h2>
                            <p class="text-blue-100">Join our network and start saving or selling</p>
                        </div>
                        <button onclick="closePartnerModal()" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-times text-3xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="partnerForm" class="p-8">
                    @csrf
                    
                    <!-- Partner Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-900 mb-3">I want to join as: *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="radio" name="type" value="clinic" required class="mr-3">
                                <div>
                                    <div class="font-bold text-gray-900">Dental Clinic</div>
                                    <div class="text-sm text-gray-600">Buy supplies at bulk prices</div>
                                </div>
                            </label>
                            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="radio" name="type" value="distributor" required class="mr-3">
                                <div>
                                    <div class="font-bold text-gray-900">Distributor</div>
                                    <div class="text-sm text-gray-600">Sell supplies to clinics</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Personal Information
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" name="name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" name="email" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" name="phone" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Business Information -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-building mr-2 text-blue-600"></i>Business Information
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Business Name *</label>
                                <input type="text" name="business_name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Business Address *</label>
                                <input type="text" name="business_address" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div class="col-span-2 sm:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                    <input type="text" name="city" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                    <input type="text" name="state" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ZIP Code *</label>
                                    <input type="text" name="zip_code" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                    <input type="text" name="country" value="IN" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>Additional Information
                        </h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                                    <input type="text" name="license_number"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Years in Business</label>
                                    <input type="number" name="years_in_business" min="0" max="100"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                                <input type="url" name="website" placeholder="https://"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tell us about your business</label>
                                <textarea name="description" rows="4" maxlength="1000"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Brief description of your clinic/business..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Error/Success Messages -->
                    <div id="formMessage" class="hidden mb-4"></div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" id="submitBtn"
                                class="flex-1 gradient-bg text-white px-8 py-4 rounded-lg font-bold text-lg hover:opacity-90 transition">
                            <i class="fas fa-paper-plane mr-2"></i>Submit Application
                        </button>
                        <button type="button" onclick="closePartnerModal()"
                                class="flex-1 border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-50 transition">
                            Cancel
                        </button>
                    </div>

                    <p class="text-sm text-gray-500 text-center mt-4">
                        * Required fields. We'll review your application within 2-3 business days.
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Scripts -->
    <script>
        function openPartnerModal() {
            document.getElementById('partnerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePartnerModal() {
            document.getElementById('partnerModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('partnerForm').reset();
            document.getElementById('formMessage').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('partnerModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closePartnerModal();
            }
        });

        // Handle form submission
        document.getElementById('partnerForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const formMessage = document.getElementById('formMessage');
            const formData = new FormData(this);
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
            
            try {
                const response = await fetch('{{ route("partner.request.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Success
                    formMessage.className = 'bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4';
                    formMessage.innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + data.message;
                    formMessage.classList.remove('hidden');
                    
                    // Reset form
                    document.getElementById('partnerForm').reset();
                    
                    // Close modal after 3 seconds
                    setTimeout(() => {
                        closePartnerModal();
                    }, 3000);
                } else {
                    // Validation errors
                    let errorMsg = '<ul class="list-disc list-inside">';
                    if (data.errors) {
                        Object.values(data.errors).forEach(error => {
                            errorMsg += '<li>' + error[0] + '</li>';
                        });
                    } else {
                        errorMsg += '<li>' + (data.message || 'An error occurred') + '</li>';
                    }
                    errorMsg += '</ul>';
                    
                    formMessage.className = 'bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4';
                    formMessage.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i><strong>Please fix the following errors:</strong>' + errorMsg;
                    formMessage.classList.remove('hidden');
                }
            } catch (error) {
                formMessage.className = 'bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4';
                formMessage.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>An error occurred. Please try again.';
                formMessage.classList.remove('hidden');
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit Application';
            }
        });
    </script>

</body>
</html>