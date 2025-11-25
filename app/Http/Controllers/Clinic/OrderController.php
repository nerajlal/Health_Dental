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
    public function index(Request $request)
    {
        $query = Order::where('clinic_id', Auth::id());

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->with('items.product')
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
            return redirect()->route('clinic.products.index')->with('error', 'Your cart is empty!');
        }

        $clinic = auth()->user();
        
        // Get products from cart
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)
            ->where('is_active', true)
            ->get();
        
        if ($products->isEmpty()) {
            return redirect()->route('clinic.products.index')->with('error', 'No valid products in cart!');
        }

        // Get custom pricing for this clinic
        $customPrices = CustomPricing::where('clinic_id', $clinic->id)
            ->whereIn('product_id', $productIds)
            ->pluck('custom_price', 'product_id');

        // Group products by distributor
        $ordersByDistributor = [];
        
        foreach ($products as $product) {
            $quantity = is_array($cart[$product->id]) 
                ? $cart[$product->id]['quantity'] 
                : (int)$cart[$product->id];
            
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
            
            $subtotal = $price * $quantity;
            
            $ordersByDistributor[$product->distributor_id]['items'][] = [
                'product' => $product,
                'quantity' => $quantity,
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

        // Clear cart
        session()->forget('cart');

        return redirect()->route('clinic.orders.index')
            ->with('success', "Successfully created {$ordersCreated} order(s)! Waiting for admin approval.");
    }

    public function addToCart(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity,
        ]);

        $cart = session()->get('cart', []);

        // Store as array with quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $validated['quantity'];
        } else {
            $cart[$product->id] = [
                'quantity' => $validated['quantity'],
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function cart()
    {
        $clinic = auth()->user();
        
        // Get cart items from session
        $cart = session()->get('cart', []);
        
        // If cart is empty, return empty collection
        if (empty($cart)) {
            return view('clinic.orders.cart', [
                'products' => collect([]),
                'total' => 0
            ]);
        }
        
        // Get product IDs from cart
        $productIds = array_keys($cart);
        
        // Get products with cart data
        $products = Product::whereIn('id', $productIds)
            ->where('is_active', true)
            ->with('distributor')
            ->get()
            ->map(function($product) use ($cart, $clinic) {
                // Handle both string and array cart structures
                if (is_array($cart[$product->id])) {
                    $product->quantity = $cart[$product->id]['quantity'] ?? 1;
                } else {
                    $product->quantity = (int)$cart[$product->id] ?? 1;
                }
                
                // Check for custom pricing first
                $customPrice = CustomPricing::where('clinic_id', $clinic->id)
                    ->where('product_id', $product->id)
                    ->first();
                
                if ($customPrice) {
                    // Use custom price if exists
                    $product->price = $customPrice->custom_price;
                } else {
                    // Calculate price: base_price + admin_margin
                    $product->price = $product->base_price + $product->admin_margin;
                }
                
                $product->subtotal = $product->price * $product->quantity;
                return $product;
            });
        
        // Calculate total
        $total = $products->sum('subtotal');
        
        return view('clinic.orders.cart', compact('products', 'total'));
    }

    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function updateCart(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity,
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $validated['quantity'];
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }
}