<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $request->validate([
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();

        CartItem::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'session_id' => $sessionId,
        ]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();

        if ($userId) {
            $cartItems = CartItem::where('user_id', $userId)
                ->orWhere('session_id', $sessionId)
                ->with('product')
                ->get();
        } else {
            $cartItems = CartItem::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();

        if ($userId) {
            $cartItems = CartItem::where('user_id', $userId)
                ->orWhere('session_id', $sessionId)
                ->with('product')
                ->get();
        } else {
            $cartItems = CartItem::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.checkout', compact('cartItems', 'total'));
    }
}
