<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('order', compact('products'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'payment_method' => 'required|in:cod,card',
        ]);

        // Get cart items
        if (auth()->check()) {
            $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();
        } else {
            $cartItems = CartItem::where('session_id', session()->getId())->with('product')->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address' => $request->address,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            // Create order items and reduce stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);

                // Reduce stock
                $product = $item->product;
                $product->stock -= $item->quantity;
                $product->save();

                // Delete cart item
                $item->delete();
            }

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Order #' . $order->order_number . ' placed successfully! Total: $' . number_format($total, 2));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order placement failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage());
        }
    }
}
