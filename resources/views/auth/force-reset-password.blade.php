@extends('layouts.landing')

@section('title', 'Reset Your Password - DentalChain')

@section('content')
<section class="py-20 bg-gray-50 min-h-screen flex items-center">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-shield-alt text-5xl gradient-text"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Password Reset Required</h2>
                <p class="text-gray-600">For your security, please change your password before continuing</p>
            </div>

            <!-- Info Message -->
            @if (session('info'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle mt-1 mr-3"></i>
                        <p class="text-sm">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.force-reset.update') }}" class="space-y-6">
                @csrf

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Current Password *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="current_password" type="password" name="current_password" required autofocus
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                               placeholder="Enter your current password">
                    </div>
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        New Password *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="Enter new password (min. 8 characters)">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Must include: uppercase, lowercase, number, and symbol (min. 8 chars)
                    </p>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm New Password *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-gray-400"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Re-enter new password">
                    </div>
                </div>

                <!-- Security Tips -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-yellow-900 mb-2">
                        <i class="fas fa-lightbulb mr-2"></i>Password Requirements
                    </h4>
                    <ul class="text-xs text-yellow-800 space-y-1">
                        <li>✓ At least 8 characters long</li>
                        <li>✓ At least one uppercase letter (A-Z)</li>
                        <li>✓ At least one lowercase letter (a-z)</li>
                        <li>✓ At least one number (0-9)</li>
                        <li>✓ At least one symbol (!@#$%^&*...)</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full gradient-bg text-white px-6 py-3 rounded-lg font-bold text-lg hover:opacity-90 transition">
                    <i class="fas fa-shield-alt mr-2"></i>Update Password & Continue
                </button>
            </form>

            <!-- Note -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-lock mr-1"></i>
                    This is a one-time security requirement. You won't see this again after updating your password.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
