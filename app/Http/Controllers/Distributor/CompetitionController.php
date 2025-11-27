<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompetitionController extends Controller
{
    public function index(Request $request)
    {
        $distributor = auth()->user();
        
        // Get all products from this distributor
        $myProducts = Product::where('distributor_id', $distributor->id)
            ->where('is_active', true)
            ->where('status', 'approved')
            ->get();

        // Get search query
        $search = $request->search;
        
        // Get all active products from OTHER distributors
        $query = Product::where('distributor_id', '!=', $distributor->id)
            ->where('is_active', true)
            ->where('status', 'approved')
            ->with('distributor');

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $competitorProducts = $query->orderBy('name', 'asc')->paginate(20);

        // For each competitor product, check if we sell the same/similar product
        $competitorProducts->getCollection()->transform(function($product) use ($myProducts, $distributor) {
            // Find if we have a similar product (same name or category)
            $mySimilarProduct = $myProducts->first(function($myProduct) use ($product) {
                return stripos($myProduct->name, $product->name) !== false 
                    || stripos($product->name, $myProduct->name) !== false
                    || $myProduct->category === $product->category;
            });

            $product->my_product = $mySimilarProduct;
            $product->price_difference = null;
            $product->i_am_cheaper = false;
            
            if ($mySimilarProduct) {
                $product->price_difference = $mySimilarProduct->base_price - $product->base_price;
                $product->i_am_cheaper = $mySimilarProduct->base_price < $product->base_price;
            }

            return $product;
        });

        return view('distributor.competition.index', compact('competitorProducts', 'myProducts', 'search'));
    }

    public function productComparison($productId)
    {
        $distributor = auth()->user();
        
        // Get the selected competitor product
        $selectedProduct = Product::where('id', $productId)
            ->with('distributor')
            ->firstOrFail();

        // Find all products with similar name or same category
        $similarProducts = Product::where('is_active', true)
            ->where('status', 'approved')
            ->where(function($query) use ($selectedProduct) {
                $query->where('name', 'like', "%{$selectedProduct->name}%")
                      ->orWhere('category', $selectedProduct->category);
            })
            ->with('distributor')
            ->get();

        // Separate my products and competitor products
        $myProducts = $similarProducts->where('distributor_id', $distributor->id);
        $competitorProducts = $similarProducts->where('distributor_id', '!=', $distributor->id);

        // Combine and rank by price
        $allProducts = $similarProducts->sortBy('base_price')->values();
        
        // Add ranking
        $rankedProducts = $allProducts->map(function($product, $index) use ($distributor) {
            $product->rank = $index + 1;
            $product->is_mine = $product->distributor_id === $distributor->id;
            $product->is_cheapest = $index === 0;
            return $product;
        });

        return view('distributor.competition.product-comparison', compact(
            'selectedProduct',
            'rankedProducts',
            'myProducts',
            'competitorProducts'
        ));
    }
}