<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CustomPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('distributor')
            ->approved(); // Only approved products

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(12);
        
        $clinicId = Auth::id();
        foreach ($products as $product) {
            $product->display_price = $product->getPriceForClinic($clinicId);
        }

        $categories = Product::approved()->distinct()->pluck('category');

        return view('clinic.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $clinicId = Auth::id();
        
        // Check for custom pricing
        $customPrice = CustomPricing::where('product_id', $product->id)
            ->where('clinic_id', $clinicId)
            ->first();

        // Calculate display price
        if ($customPrice) {
            $price = $customPrice->custom_price;
            $hasCustomPricing = true;
        } else {
            // Default markup of 15%
            $price = $product->base_price * 1.15;
            $hasCustomPricing = false;
        }

        return view('clinic.products.show', compact('product', 'price', 'hasCustomPricing'));
    }
}