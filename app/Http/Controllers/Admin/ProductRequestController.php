<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProductRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductRequest::with(['clinic', 'assignedDistributor']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by urgency
        if ($request->has('urgency') && $request->urgency != '') {
            $query->where('urgency', $request->urgency);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.product-requests.index', compact('requests'));
    }

    public function show(ProductRequest $productRequest)
    {
        $productRequest->load(['clinic', 'reviewer', 'assignedDistributor']);
        
        return view('admin.product-requests.show', compact('productRequest'));
    }

    public function approve(Request $request, ProductRequest $productRequest)
    {
        $productRequest->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Product request approved! All distributors can now see this request.');
    }

    public function reject(Request $request, ProductRequest $productRequest)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $productRequest->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Product request rejected.');
    }

    public function updateStatus(Request $request, ProductRequest $productRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,approved,rejected,fulfilled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $productRequest->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $productRequest->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}