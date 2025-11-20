<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('distributor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('distributor.products.index', compact('products'));
    }

    public function create()
    {
        return view('distributor.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'company' => 'nullable|string',
            'category' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['distributor_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('distributor.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        // Ensure distributor can only edit their own products
        if ($product->distributor_id !== Auth::id()) {
            abort(403);
        }

        return view('distributor.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Ensure distributor can only update their own products
        if ($product->distributor_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'company' => 'nullable|string',
            'category' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('distributor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Ensure distributor can only delete their own products
        if ($product->distributor_id !== Auth::id()) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('distributor.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}