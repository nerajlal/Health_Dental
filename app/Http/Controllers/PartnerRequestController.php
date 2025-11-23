<?php

namespace App\Http\Controllers;

use App\Models\PartnerRequest;
use Illuminate\Http\Request;

class PartnerRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:clinic,distributor',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:partner_requests,email|unique:users,email',
            'phone' => 'required|string|max:20',
            'business_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'license_number' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'years_in_business' => 'nullable|integer|min:0|max:100',
            'website' => 'nullable|url|max:255',
        ], [
            'email.unique' => 'This email is already registered or has a pending request.',
        ]);

        PartnerRequest::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your partnership request has been submitted successfully. Our team will review it and contact you within 2-3 business days.'
        ]);
    }
}