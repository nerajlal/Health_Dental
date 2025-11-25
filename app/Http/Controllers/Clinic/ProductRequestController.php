<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Http\Request;

class ProductRequestController extends Controller
{
    public function index()
    {
        $requests = ProductRequest::where('clinic_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('clinic.product-requests.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'estimated_quantity' => 'nullable|integer|min:1',
            'urgency' => 'required|in:normal,urgent,very_urgent',
            'preferred_distributor' => 'nullable|string|max:255',
            'expected_price' => 'nullable|numeric|min:0',
            'reference_link' => 'nullable|url|max:500',
        ]);

        $validated['clinic_id'] = auth()->id();
        $validated['status'] = 'pending';

        ProductRequest::create($validated);

        return redirect()->back()->with('success', 'Product request submitted successfully! We will review it shortly.');
    }

    public function show(ProductRequest $productRequest)
    {
        // Ensure clinic can only see their own requests
        if ($productRequest->clinic_id !== auth()->id()) {
            abort(403);
        }

        return view('clinic.product-requests.show', compact('productRequest'));
    }
}