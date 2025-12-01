<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the user has exceeded the rate limit
        $this->ensureIsNotRateLimited($request);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Clear the rate limiter on successful login
            RateLimiter::clear($this->throttleKey($request));

            $user = Auth::user();

            // Check if user needs to reset password
            if ($user->needsPasswordReset()) {
                return redirect()->route('password.force-reset')
                    ->with('info', 'Please change your password before continuing.');
            }

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'clinic') {
                return redirect()->route('clinic.dashboard');
            } elseif ($user->role === 'distributor') {
                return redirect()->route('distributor.dashboard');
            }

            return redirect('/');
        }

        // Increment the rate limiter on failed login
        RateLimiter::hit($this->throttleKey($request), 60);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        $minutes = ceil($seconds / 60);

        throw ValidationException::withMessages([
            'email' => "Too many login attempts. Please try again in {$minutes} minute" . ($minutes > 1 ? 's' : '') . ".",
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForceResetForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // If user doesn't need password reset, redirect to dashboard
        if (!Auth::user()->needsPasswordReset()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isClinic()) {
                return redirect()->route('clinic.dashboard');
            } elseif ($user->isDistributor()) {
                return redirect()->route('distributor.dashboard');
            }
        }

        return view('auth.force-reset-password');
    }

    public function forceResetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verify current password
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password and set password_changed_at
        $user->update([
            'password' => \Hash::make($request->password),
            'password_changed_at' => now(),
        ]);

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Password updated successfully!');
        } elseif ($user->isClinic()) {
            return redirect()->route('clinic.dashboard')->with('success', 'Password updated successfully!');
        } elseif ($user->isDistributor()) {
            return redirect()->route('distributor.dashboard')->with('success', 'Password updated successfully!');
        }

        return redirect('/')->with('success', 'Password updated successfully!');
    }
}
