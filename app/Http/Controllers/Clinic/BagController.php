<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\Product;
use App\Models\CustomPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BagController extends Controller
{
    public function index()
    {
        $clinic = auth()->user();
        $bagItems = Bag::where('clinic_id', $clinic->id)->with('product')->get();

        $total = 0;
        foreach ($bagItems as $item) {
            $product = $item->product;
            $customPrice = CustomPricing::where('clinic_id', $clinic->id)
                ->where('product_id', $product->id)
                ->first();

            if ($customPrice) {
                $product->price = $customPrice->custom_price;
            } else {
                $product->price = $product->base_price + $product->admin_margin;
            }

            $product->subtotal = $product->price * $item->quantity;
            $total += $product->subtotal;
        }

        return view('clinic.bags.index', compact('bagItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity,
        ]);

        $clinicId = Auth::id();

        $bagItem = Bag::where('clinic_id', $clinicId)
            ->where('product_id', $product->id)
            ->first();

        if ($bagItem) {
            $bagItem->quantity += $validated['quantity'];
            $bagItem->save();
        } else {
            Bag::create([
                'clinic_id' => $clinicId,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
            ]);
        }

        return redirect()->back()->with('success', 'Product added to bag!');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity,
        ]);

        $clinicId = Auth::id();

        $bagItem = Bag::where('clinic_id', $clinicId)
            ->where('product_id', $product->id)
            ->first();

        if ($bagItem) {
            $bagItem->quantity = $validated['quantity'];
            $bagItem->save();
        }

        return redirect()->back()->with('success', 'Bag updated!');
    }

    public function remove(Product $product)
    {
        $clinicId = Auth::id();

        Bag::where('clinic_id', $clinicId)
            ->where('product_id', $product->id)
            ->delete();

        return redirect()->back()->with('success', 'Product removed from bag!');
    }
}
