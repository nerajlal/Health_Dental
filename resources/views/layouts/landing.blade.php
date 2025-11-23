<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DentalChain - Bulk Dental Supply Procurement')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #6366f1 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #1e40af 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .mobile-menu {
            transition: max-height 0.3s ease-in-out;
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
                    <a href="{{ route('landing.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Home</a>
                    <a href="{{ route('landing.about') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">About</a>
                    <a href="{{ route('landing.contact') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Contact</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium transition">Partner With Us</a>
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
                    <a href="{{ route('landing.contact') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md font-medium">Contact</a>
                    <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md font-medium">Partner With Us</a>
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
                        <li><a href="{{ route('landing.contact') }}" class="text-gray-400 hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Partner With Us</a></li>
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
</body>
</html>