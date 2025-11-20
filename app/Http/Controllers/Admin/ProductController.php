<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomPricing;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('distributor');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->distributor) {
            $query->where('distributor_id', $request->distributor);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $distributors = User::where('role', 'distributor')->where('is_active', true)->get();
        $pendingCount = Product::where('status', 'pending')->count();

        return view('admin.products.index', compact('products', 'distributors', 'pendingCount'));
    }

    public function edit(Product $product)
    {
        $distributors = User::where('role', 'distributor')->get();
        return view('admin.products.edit', compact('product', 'distributors'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'distributor_id' => 'required|exists:users,id',
            'is_active' => 'boolean',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function customPricing(Product $product)
    {
        $clinics = User::where('role', 'clinic')->get();
        $customPricing = CustomPricing::where('product_id', $product->id)
            ->with('clinic')
            ->get();

        return view('admin.products.custom-pricing', compact('product', 'clinics', 'customPricing'));
    }

    public function storeCustomPricing(Request $request, Product $product)
    {
        $validated = $request->validate([
            'clinic_id' => 'required|exists:users,id',
            'custom_price' => 'required|numeric|min:0',
        ]);

        CustomPricing::updateOrCreate(
            [
                'product_id' => $product->id,
                'clinic_id' => $validated['clinic_id']
            ],
            [
                'custom_price' => $validated['custom_price']
            ]
        );

        return redirect()->back()
            ->with('success', 'Custom pricing set successfully.');
    }

    public function destroyCustomPricing(CustomPricing $customPricing)
    {
        $customPricing->delete();

        return redirect()->back()
            ->with('success', 'Custom pricing removed successfully.');
    }

    public function pending()
    {
        $products = Product::with('distributor')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.products.pending', compact('products'));
    }

    public function approve(Request $request, Product $product)
    {
        if ($request->action === 'approve') {
            $request->validate([
                'admin_margin' => 'required|numeric|min:0',
            ]);

            $product->update([
                'admin_margin' => $request->admin_margin,
                'final_price' => $product->base_price + $request->admin_margin,
                'status' => 'approved',
                'is_active' => true,
                'admin_notes' => $request->admin_notes,
            ]);

            return redirect()->route('admin.products.pending')
                ->with('success', 'Product approved successfully!');
        } else {
            $product->update([
                'status' => 'rejected',
                'is_active' => false,
                'admin_notes' => $request->admin_notes,
            ]);

            return redirect()->route('admin.products.pending')
                ->with('success', 'Product rejected.');
        }
    }
    
}