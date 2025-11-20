<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = User::where('role', 'distributor')
            ->withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.distributors.index', compact('distributors'));
    }

    public function create()
    {
        return view('admin.distributors.create');
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

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'distributor';

        User::create($validated);

        return redirect()->route('admin.distributors.index')
            ->with('success', 'Distributor added successfully.');
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