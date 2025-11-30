<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | DentalChain</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
        
        .playfair {
            font-family: 'Playfair Display', serif;
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #0f2557 0%, #1e3a8a 50%, #3b82f6 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .search-box {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .search-box input {
            width: 100%;
            padding: 1rem 3rem 1rem 1.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 9999px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .search-box button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #0f2557 0%, #1e3a8a 50%, #3b82f6 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-box button:hover {
            transform: translateY(-50%) scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-4xl w-full">
            <!-- Main Content -->
            <div class="text-center mb-12">
                <!-- 404 Number -->
                <div class="floating mb-8">
                    <h1 class="text-9xl font-bold gradient-text playfair">404</h1>
                </div>
                
                <!-- Error Message -->
                <h2 class="text-4xl font-bold text-gray-900 mb-4 playfair">Page Not Found</h2>
                <p class="text-xl text-gray-600 mb-8">
                    Oops! The page you're looking for doesn't exist or has been moved.
                </p>
                
                <!-- Search Box -->
                <div class="search-box mb-12">
                    <form action="{{ url('/') }}" method="GET">
                        <input type="text" name="search" placeholder="Search for products, orders, or pages..." class="shadow-lg">
                        <button type="submit">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Home -->
                <a href="{{ url('/') }}" class="card p-6 text-center group">
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-home text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Go Home</h3>
                    <p class="text-sm text-gray-600">Return to homepage</p>
                </a>
                
                <!-- Dashboard -->
                @auth
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="card p-6 text-center group">
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-th-large text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Dashboard</h3>
                    <p class="text-sm text-gray-600">Go to your dashboard</p>
                </a>
                @else
                <a href="{{ route('login') }}" class="card p-6 text-center group">
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-sign-in-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Login</h3>
                    <p class="text-sm text-gray-600">Access your account</p>
                </a>
                @endauth
                
                <!-- Contact -->
                <a href="{{ route('landing.contact') }}" class="card p-6 text-center group">
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Contact Us</h3>
                    <p class="text-sm text-gray-600">Get help from our team</p>
                </a>
            </div>
            
            <!-- Additional Help -->
            <div class="card p-8 text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4 playfair">Need Help?</h3>
                <p class="text-gray-600 mb-6">
                    If you believe this is an error, please contact our support team or try one of the links above.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('landing.contact') }}" class="btn-primary">
                        <i class="fas fa-headset mr-2"></i>Contact Support
                    </a>
                    <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Go Back
                    </a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-12">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} <span class="gradient-text font-semibold">DentalChain</span>. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
