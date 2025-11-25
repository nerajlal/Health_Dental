<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRequestController extends Controller
{
    public function index()
    {
        $distributor = auth()->user();
        
        // Show all approved requests (not assigned to specific distributor)
        $requests = ProductRequest::where('status', 'approved')
            ->orWhere('assigned_distributor_id', $distributor->id)
            ->with('clinic')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('distributor.product-requests.index', compact('requests'));
    }

    public function show(ProductRequest $productRequest)
    {
        // Allow viewing approved requests or assigned requests
        if ($productRequest->status !== 'approved' && $productRequest->assigned_distributor_id !== auth()->id()) {
            abort(403);
        }

        $productRequest->load('clinic');
        
        return view('distributor.product-requests.show', compact('productRequest'));
    }

    public function fulfill(Request $request, ProductRequest $productRequest)
    {
        // Ensure distributor can only fulfill their assigned requests
        if ($productRequest->assigned_distributor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productRequest->update([
            'status' => 'fulfilled',
        ]);

        return redirect()->back()->with('success', 'Product request marked as fulfilled!');
    }

    public function createProduct(ProductRequest $productRequest)
    {
        // Allow creating products for approved requests
        if ($productRequest->status !== 'approved') {
            return redirect()->route('distributor.product-requests.index')
                ->with('error', 'This request is not available for fulfillment.');
        }

        return view('distributor.product-requests.create-product', compact('productRequest'));
    }

    public function storeProduct(Request $request, ProductRequest $productRequest)
    {
        // Allow creating products for approved requests
        if ($productRequest->status !== 'approved') {
            return redirect()->route('distributor.product-requests.index')
                ->with('error', 'This request is not available for fulfillment.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'category' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'admin_margin' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['distributor_id'] = auth()->id();
        $validated['is_active'] = true;

        $product = Product::create($validated);

        // Mark as fulfilled and assign to this distributor
        $productRequest->update([
            'status' => 'fulfilled',
            'assigned_distributor_id' => auth()->id(),
            'assigned_at' => now(),
        ]);

        return redirect()->route('distributor.product-requests.index')
            ->with('success', 'Product created successfully and request fulfilled!');
    }
}