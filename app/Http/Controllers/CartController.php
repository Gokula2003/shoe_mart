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
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to add items to your cart.')
                ->with('intended', route('products.show', $productId));
        }

        $product = Product::findOrFail($productId);
        
        $request->validate([
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);

        // Check if product has enough stock
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock available.');
        }

        $userId = Auth::id();
        $sessionId = session()->getId();

        CartItem::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'session_id' => $sessionId,
        ]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('info', 'Please login to view your cart.');
        }

        $userId = Auth::id();
        $sessionId = session()->getId();

        $cartItems = CartItem::where('user_id', $userId)
            ->orWhere('session_id', $sessionId)
            ->with('product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        // Authorization check
        $this->authorize('delete', $cartItem);
        
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('info', 'Please login to proceed with checkout.');
        }

        $userId = Auth::id();
        $sessionId = session()->getId();

        $cartItems = CartItem::where('user_id', $userId)
            ->orWhere('session_id', $sessionId)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.checkout', compact('cartItems', 'total'));
    }
}
