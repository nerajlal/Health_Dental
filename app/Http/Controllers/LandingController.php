<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function about()
    {
        return view('landing.about');
    }

    public function contact()
    {
        return view('landing.contact');
    }

    public function story()
    {
        return view('landing.story');
    }

    public function privacy()
    {
        return view('landing.privacy');
    }

    public function terms()
    {
        return view('landing.terms');
    }

    public function refund()
    {
        return view('landing.refund');
    }

    public function faq()
    {
        return view('landing.faq');
    }

    public function partnerRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:clinic,distributor',
            'business_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'license_number' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:100',
        ]);

        // Create user account (inactive by default)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => false, // Inactive until admin approves
            'business_name' => $validated['business_name'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'],
            'license_number' => $validated['license_number'] ?? null,
            'tax_id' => $validated['tax_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Your account is pending admin approval. You will receive an email once approved.'
        ]);
    }
}