<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\CustomPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('clinic_id', Auth::id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('clinic.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure clinic can only see their own orders
        if ($order->clinic_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product.distributor');
        return view('clinic.orders.show', compact('order'));
    }

    public function create()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('clinic.products.index')
                ->with('error', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $clinicId = Auth::id();
        
        $customPrices = CustomPricing::where('clinic_id', $clinicId)
            ->whereIn('product_id', array_keys($cart))
            ->pluck('custom_price', 'product_id');

        $margin = 15;
        $total = 0;

        foreach ($products as $product) {
            if (isset($customPrices[$product->id])) {
                $price = $customPrices[$product->id];
            } else {
                $price = $product->base_price * (1 + ($margin / 100));
            }
            $product->display_price = $price;
            $product->quantity = $cart[$product->id];
            $product->subtotal = $price * $cart[$product->id];
            $total += $product->subtotal;
        }

        return view('clinic.orders.create', compact('products', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('clinic.products.index')
                ->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        try {
            $clinicId = Auth::id();
            $products = Product::whereIn('id', array_keys($cart))->get();
            
            $customPrices = CustomPricing::where('clinic_id', $clinicId)
                ->whereIn('product_id', array_keys($cart))
                ->pluck('custom_price', 'product_id');

            $margin = 15;
            $totalAmount = 0;

            // Create order
            $order = Order::create([
                'clinic_id' => $clinicId,
                'status' => 'pending',
                'total_amount' => 0
            ]);

            // Create order items
            foreach ($products as $product) {
                if (isset($customPrices[$product->id])) {
                    $price = $customPrices[$product->id];
                } else {
                    $price = $product->base_price * (1 + ($margin / 100));
                }

                $quantity = $cart[$product->id];
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price
                ]);
            }

            // Update order total
            $order->update(['total_amount' => $totalAmount]);

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('clinic.orders.show', $order)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function addToCart(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id] += $validated['quantity'];
        } else {
            $cart[$product->id] = $validated['quantity'];
        }

        session()->put('cart', $cart);

        return redirect()->back()
            ->with('success', 'Product added to cart!');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return view('clinic.orders.cart', ['products' => [], 'total' => 0]);
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $clinicId = Auth::id();
        
        $customPrices = CustomPricing::where('clinic_id', $clinicId)
            ->whereIn('product_id', array_keys($cart))
            ->pluck('custom_price', 'product_id');

        $margin = 15;
        $total = 0;

        foreach ($products as $product) {
            if (isset($customPrices[$product->id])) {
                $price = $customPrices[$product->id];
            } else {
                $price = $product->base_price * (1 + ($margin / 100));
            }
            $product->display_price = $price;
            $product->quantity = $cart[$product->id];
            $product->subtotal = $price * $cart[$product->id];
            $total += $product->subtotal;
        }

        return view('clinic.orders.cart', compact('products', 'total'));
    }

    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', 'Product removed from cart.');
    }

    public function updateCart(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id] = $validated['quantity'];
            session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', 'Cart updated.');
    }
}