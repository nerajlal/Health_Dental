<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | DentalChain</title>
    
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
        
        .pulse-error {
            animation: pulse-error 2s ease-in-out infinite;
        }
        
        @keyframes pulse-error {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-3xl w-full">
            <!-- Main Content -->
            <div class="text-center mb-12">
                <!-- Error Icon -->
                <div class="pulse-error mb-8">
                    <div class="w-32 h-32 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                        <i class="fas fa-exclamation-triangle text-red-600 text-6xl"></i>
                    </div>
                </div>
                
                <!-- Error Message -->
                <h1 class="text-6xl font-bold gradient-text playfair mb-4">500</h1>
                <h2 class="text-3xl font-bold text-gray-900 mb-4 playfair">Server Error</h2>
                <p class="text-xl text-gray-600 mb-8">
                    Oops! Something went wrong on our end. We're working to fix it.
                </p>
            </div>
            
            <!-- Error Details -->
            <div class="card p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4 playfair">What happened?</h3>
                <p class="text-gray-600 mb-4">
                    Our server encountered an unexpected error and couldn't complete your request. This issue has been automatically logged and our team will investigate it.
                </p>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-yellow-600 text-xl mt-1 mr-3"></i>
                        <div>
                            <p class="font-semibold text-yellow-900 mb-1">What you can do:</p>
                            <ul class="text-sm text-yellow-800 space-y-1">
                                <li>• Try refreshing the page</li>
                                <li>• Go back and try again</li>
                                <li>• Contact support if the problem persists</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card p-8 text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 playfair">Quick Actions</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <button onclick="location.reload()" class="btn-primary">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh Page
                    </button>
                    <a href="{{ url('/') }}" class="btn-primary">
                        <i class="fas fa-home mr-2"></i>Go Home
                    </a>
                    <a href="{{ route('landing.contact') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition inline-flex items-center">
                        <i class="fas fa-headset mr-2"></i>Contact Support
                    </a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} <span class="gradient-text font-semibold">DentalChain</span>. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
