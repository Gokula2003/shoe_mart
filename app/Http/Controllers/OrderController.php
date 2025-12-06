<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;

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
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Here you would typically:
        // 1. Create an order record in the database
        // 2. Create order items
        // 3. Reduce product stock
        // 4. Process payment if needed
        // 5. Send confirmation email

        // For now, we'll just clear the cart and show success message
        foreach ($cartItems as $item) {
            // Reduce stock
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->save();

            // Delete cart item
            $item->delete();
        }

        return redirect()->route('dashboard')->with('success', 'Order placed successfully! Total: $' . number_format($total, 2));
    }
}
