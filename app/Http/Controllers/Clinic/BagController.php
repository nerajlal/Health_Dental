<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\Product;
use App\Models\CustomPricing;
use App\Models\Order;
use App\Models\OrderItem;
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

    public function quickOrder()
    {
        $clinic = auth()->user();
        $bagItems = Bag::where('clinic_id', $clinic->id)->with('product')->get();

        if ($bagItems->isEmpty()) {
            return redirect()->route('clinic.bag.index')->with('error', 'Your bag is empty!');
        }

        // Get custom pricing
        $productIds = $bagItems->pluck('product_id')->toArray();
        $customPrices = CustomPricing::where('clinic_id', $clinic->id)
            ->whereIn('product_id', $productIds)
            ->pluck('custom_price', 'product_id');

        // Group products by distributor
        $ordersByDistributor = [];
        
        foreach ($bagItems as $item) {
            $product = $item->product;
            
            // Check if product is still active and in stock
            if (!$product->is_active) {
                return redirect()->route('clinic.bag.index')
                    ->with('error', "Product '{$product->name}' is no longer available.");
            }
            
            if ($item->quantity > $product->stock_quantity) {
                return redirect()->route('clinic.bag.index')
                    ->with('error', "Not enough stock for '{$product->name}'. Available: {$product->stock_quantity}");
            }
            
            // Calculate price
            if (isset($customPrices[$product->id])) {
                $price = $customPrices[$product->id];
            } else {
                $price = $product->base_price + $product->admin_margin;
            }
            
            if (!isset($ordersByDistributor[$product->distributor_id])) {
                $ordersByDistributor[$product->distributor_id] = [
                    'items' => [],
                    'total' => 0
                ];
            }
            
            $subtotal = $price * $item->quantity;
            
            $ordersByDistributor[$product->distributor_id]['items'][] = [
                'product' => $product,
                'quantity' => $item->quantity,
                'price' => $price,
                'subtotal' => $subtotal
            ];
            
            $ordersByDistributor[$product->distributor_id]['total'] += $subtotal;
        }

        // Create orders for each distributor
        $ordersCreated = 0;
        
        foreach ($ordersByDistributor as $distributorId => $orderData) {
            $order = Order::create([
                'clinic_id' => $clinic->id,
                'distributor_id' => $distributorId,
                'total_amount' => $orderData['total'],
                'status' => 'pending',
            ]);

            foreach ($orderData['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            
            $ordersCreated++;
        }

        // Don't clear bag items - they remain for future orders
        // Bag items persist after ordering

        return redirect()->route('clinic.orders.index')
            ->with('success', "Quick order successful! Created {$ordersCreated} order(s) from your bag. Bag items saved for future orders.");
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
