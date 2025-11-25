<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dental Supply Management')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @auth
    <nav class="bg-white shadow-lg fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="-ml-2 mr-2 flex items-center sm:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                    <div class="flex-shrink-0 flex items-center">
                        <a href="@if(auth()->user()->role == 'admin') {{ route('admin.dashboard') }}
                                @elseif(auth()->user()->role == 'clinic') {{ route('clinic.dashboard') }}
                                @else {{ route('distributor.dashboard') }} @endif" 
                           class="text-2xl font-bold text-blue-600">
                            <i class="fas fa-tooth mr-2"></i>DentalSupply
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.clinics.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Clinics
                            </a>
                            <a href="{{ route('admin.distributors.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Distributors
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Products
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Orders
                            </a>
                            <a href="{{ route('admin.analytics') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Analytics
                            </a>
                            <a href="{{ route('admin.margin') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Margins
                            </a>
                            <a href="{{ route('admin.product-requests.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Requests
                            </a>
                        @elseif(auth()->user()->role == 'clinic')
                            <a href="{{ route('clinic.dashboard') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="{{ route('clinic.products.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Products
                            </a>
                            <a href="{{ route('clinic.orders.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                My Orders
                            </a>
                            <a href="{{ route('clinic.product-requests.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Request Product
                            </a>
                            <!-- <button onclick="openRequestModal()" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-plus-circle mr-2"></i>Request Product
                            </button> -->
                        @else
                            <a href="{{ route('distributor.dashboard') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="{{ route('distributor.products.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                My Products
                            </a>
                            <a href="{{ route('distributor.orders.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Orders
                            </a>
                            <a href="{{ route('distributor.analytics') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Analytics
                            </a>
                        @endif
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="ml-3 relative">
                        <div class="flex items-center space-x-4">
                            @if(auth()->user()->role == 'clinic')
                                <a href="{{ route('clinic.cart') }}" class="relative text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-shopping-cart text-xl"></i>
                                    @if(count(session('cart', [])) > 0)
                                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                            {{ count(session('cart', [])) }}
                                        </span>
                                    @endif
                                </a>
                            @endif
                            <span class="text-gray-700">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="flex items-center sm:hidden">
                    @if(auth()->user()->role == 'clinic')
                        <a href="{{ route('clinic.cart') }}" class="relative text-gray-500 hover:text-gray-700 p-2">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @if(count(session('cart', [])) > 0)
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center">
                                    {{ count(session('cart', [])) }}
                                </span>
                            @endif
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Dashboard</a>
                    <a href="{{ route('admin.clinics.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Clinics</a>
                    <a href="{{ route('admin.distributors.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Distributors</a>
                    <a href="{{ route('admin.products.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Products</a>
                    <a href="{{ route('admin.orders.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Orders</a>
                    <a href="{{ route('admin.analytics') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Analytics</a>
                    <a href="{{ route('admin.margin') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Margin</a>
                    <a href="{{ route('admin.product-requests.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Requests</a>
                @elseif(auth()->user()->role == 'clinic')
                    <a href="{{ route('clinic.dashboard') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Dashboard</a>
                    <a href="{{ route('clinic.products.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Products</a>
                    <a href="{{ route('clinic.orders.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">My Orders</a>
                    <a href="{{ route('clinic.product-requests.index') }}"class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        Request Product
                    </a>
                    <!-- <button onclick="openRequestModal()" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
                        <i class="fas fa-plus-circle mr-2"></i>Request Product
                    </button> -->
                @else
                    <a href="{{ route('distributor.dashboard') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Dashboard</a>
                    <a href="{{ route('distributor.products.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">My Products</a>
                    <a href="{{ route('distributor.orders.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Orders</a>
                    <a href="{{ route('distributor.analytics') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Analytics</a>
                @endif
            </div>
            <div class="pt-4 pb-4 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-xl font-medium leading-none text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Main Content -->
    <main class="py-6 mt-16">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; 2024 Dental Supply Management System. All rights reserved.
            </p>
        </div>
    </footer>

    @if(auth()->check() && auth()->user()->role == 'clinic')
    <a href="https://wa.me/918547470675" target="_blank" class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg z-50 flex items-center justify-center transition-transform hover:scale-110">
        <i class="fab fa-whatsapp text-3xl"></i>
    </a>
    @endif

    @yield('scripts')
    <script>
        const btn = document.querySelector(".mobile-menu-button");
        const menu = document.querySelector("#mobile-menu");

        if (btn && menu) {
            btn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
            });
        }
    </script>

    <!-- Request Product Modal -->
@auth
@if(auth()->user()->role === 'clinic')
<div id="requestProductModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Request a Product</h3>
                    <p class="text-sm text-gray-600 mt-1">Can't find what you need? Let us know!</p>
                </div>
                <button onclick="closeRequestModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('clinic.product-requests.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-4">
                    <!-- Product Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="product_name" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="e.g., Dental X-Ray Films">
                    </div>

                    <!-- Company & Category -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company/Brand</label>
                            <input type="text" name="company"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="e.g., 3M, Dentsply">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Category</option>
                                <option value="Instruments">Instruments</option>
                                <option value="Equipment">Equipment</option>
                                <option value="Consumables">Consumables</option>
                                <option value="Implants">Implants</option>
                                <option value="Orthodontics">Orthodontics</option>
                                <option value="Endodontics">Endodontics</option>
                                <option value="Prosthetics">Prosthetics</option>
                                <option value="Infection Control">Infection Control</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Please describe the product, specifications, or any specific requirements..."></textarea>
                    </div>

                    <!-- Quantity & Urgency -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Quantity</label>
                            <input type="number" name="estimated_quantity" min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="How many units?">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Urgency <span class="text-red-500">*</span>
                            </label>
                            <select name="urgency" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="normal">Normal</option>
                                <option value="urgent">Urgent (Within 1 week)</option>
                                <option value="very_urgent">Very Urgent (ASAP)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Preferred Distributor & Expected Price -->
                    <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Distributor</label>
                            <input type="text" name="preferred_distributor"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Expected Price (USD)</label>
                            <input type="number" name="expected_price" min="0" step="0.01"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="e.g., 99.99">
                        </div>
                    </div> -->

                    <!-- Reference Link -->
                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reference Link</label>
                        <input type="url" name="reference_link"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="https://example.com/product">
                        <p class="text-xs text-gray-500 mt-1">Link to product page, specification sheet, or similar product</p>
                    </div> -->
                </div>

                <!-- Info Box -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-info-circle text-blue-600 text-lg mr-3 flex-shrink-0"></i>
                        <div class="text-sm text-blue-900">
                            <p class="font-medium mb-1">What happens next?</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Our team will review your request within 24-48 hours</li>
                                <li>We'll contact distributors to check availability</li>
                                <li>You'll be notified once the product is added to catalog</li>
                                <li>Track your request status in "My Product Requests"</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Request
                    </button>
                    <button type="button" onclick="closeRequestModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRequestModal() {
    document.getElementById('requestProductModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRequestModal() {
    document.getElementById('requestProductModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeRequestModal();
    }
});

// Close modal on outside click
document.getElementById('requestProductModal')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closeRequestModal();
    }
});
</script>
@endif
@endauth
</body>
</html>
