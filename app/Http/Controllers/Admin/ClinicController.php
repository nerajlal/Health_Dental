<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClinicController extends Controller
{
    public function index()
    {
        $clinics = User::where('role', 'clinic')
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.clinics.index', compact('clinics'));
    }

    public function create()
    {
        return view('admin.clinics.create');
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

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'clinic';

        User::create($validated);

        return redirect()->route('admin.clinics.index')
            ->with('success', 'Clinic added successfully.');
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