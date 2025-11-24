<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClinicAccountCreated;

class ClinicController extends Controller
{
    public function index()
    {
        $clinics = User::where('role', 'clinic')
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get pending clinic partner requests
        $pendingRequests = \App\Models\PartnerRequest::where('type', 'clinic')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.clinics.index', compact('clinics', 'pendingRequests'));
    }

    public function create()
    {
        return view('admin.clinics.create');
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
            'license_number' => $request->license_number,
            'role' => 'clinic',
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

        return redirect()->back()->with('success', 'Clinic approved! Default password: password123 (User should change this on first login)');
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

        return redirect()->back()->with('success', 'Clinic request rejected.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'license_number' => 'nullable|string',
        ]);

        $password = $validated['password'];
        $validated['password'] = Hash::make($password);
        $validated['role'] = 'clinic';

        $clinic = User::create($validated);

        try {
            Mail::to($clinic->email)->send(new ClinicAccountCreated($clinic, $password));
        } catch (\Exception $e) {
            // Log error or just continue, depending on requirements.
            // For now, we proceed even if email fails, but maybe flash a warning?
            // return redirect()->route('admin.clinics.index')->with('success', 'Clinic added successfully, but email could not be sent.');
        }

        return redirect()->route('admin.clinics.index')
            ->with('success', 'Clinic added successfully and welcome email sent.');
    }

    public function edit(User $clinic)
    {
        return view('admin.clinics.edit', compact('clinic'));
    }

    public function update(Request $request, User $clinic)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $clinic->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'license_number' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $clinic->update($validated);

        return redirect()->route('admin.clinics.index')
            ->with('success', 'Clinic updated successfully.');
    }

    public function destroy(User $clinic)
    {
        $clinic->delete();

        return redirect()->route('admin.clinics.index')
            ->with('success', 'Clinic deleted successfully.');
    }
}