<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\DistributorAccountCreated;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = User::where('role', 'distributor')
            ->withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get pending distributor partner requests
        $pendingRequests = \App\Models\PartnerRequest::where('type', 'distributor')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.distributors.index', compact('distributors', 'pendingRequests'));
    }

    public function create()
    {
        return view('admin.distributors.create');
    }

    public function approveRequest($id)
    {
        $request = \App\Models\PartnerRequest::findOrFail($id);
        
        if ($request->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->business_address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'business_registration' => $request->license_number,
            'role' => 'distributor',
            'is_active' => true,
            'password' => \Hash::make('password123'), // Default password
        ]);

        // Update request status
        $request->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'admin_notes' => 'Approved and account created',
        ]);

        return redirect()->back()->with('success', 'Distributor approved! Default password: password123 (User should change this on first login)');
    }

    public function rejectRequest(Request $request, $id)
    {
        $partnerRequest = \App\Models\PartnerRequest::findOrFail($id);
        
        if ($partnerRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $validated = $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $partnerRequest->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->back()->with('success', 'Distributor request rejected.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'business_registration' => 'nullable|string',
        ]);

        $password = $validated['password'];
        $validated['password'] = Hash::make($password);
        $validated['role'] = 'distributor';

        $distributor = User::create($validated);

        try {
            Mail::to($distributor->email)->send(new DistributorAccountCreated($distributor, $password));
        } catch (\Exception $e) {
            // Log error
        }

        return redirect()->route('admin.distributors.index')
            ->with('success', 'Distributor added successfully and welcome email sent.');
    }

    public function edit(User $distributor)
    {
        return view('admin.distributors.edit', compact('distributor'));
    }

    public function update(Request $request, User $distributor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $distributor->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'business_registration' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $distributor->update($validated);

        return redirect()->route('admin.distributors.index')
            ->with('success', 'Distributor updated successfully.');
    }

    public function destroy(User $distributor)
    {
        $distributor->delete();

        return redirect()->route('admin.distributors.index')
            ->with('success', 'Distributor deleted successfully.');
    }
}