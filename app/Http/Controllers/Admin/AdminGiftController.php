<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftOrder;
use Illuminate\Http\Request;

class AdminGiftController extends Controller
{
    /**
     * Display all gift orders.
     */
    public function index(Request $request)
    {
        $query = GiftOrder::with(['sender', 'product']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by recipient name or email
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('recipient_name', 'like', '%' . $request->search . '%')
                  ->orWhere('recipient_email', 'like', '%' . $request->search . '%');
            });
        }

        $gifts = $query->latest()->paginate(20);

        return view('admin.gifts.index', compact('gifts'));
    }

    /**
     * Show form to create new gift order.
     */
    public function create()
    {
        return view('admin.gifts.create');
    }

    /**
     * Store a new gift order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'recipient_phone' => 'required|string|max:20',
            'recipient_address' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'gift_message' => 'nullable|string|max:500',
        ]);

        $product = \App\Models\Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        // Calculate total
        $totalAmount = $product->price * $request->quantity;

        // Create gift order
        $giftOrder = GiftOrder::create([
            'sender_id' => $request->sender_id,
            'recipient_name' => $request->recipient_name,
            'recipient_email' => $request->recipient_email,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount,
            'gift_message' => $request->gift_message,
            'status' => 'pending',
        ]);

        // Reduce stock
        $product->decrement('stock', $request->quantity);

        return redirect()->route('admin.gifts.index')
            ->with('success', 'Gift order created successfully.');
    }

    /**
     * Display gift order details.
     */
    public function show($id)
    {
        $giftOrder = GiftOrder::with(['sender', 'product'])->findOrFail($id);

        return view('admin.gifts.show', compact('giftOrder'));
    }

    /**
     * Update gift order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $giftOrder = GiftOrder::findOrFail($id);
        $giftOrder->update(['status' => $request->status]);

        return back()->with('success', 'Gift order status updated successfully.');
    }

    /**
     * Update tracking number.
     */
    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        $giftOrder = GiftOrder::findOrFail($id);
        $giftOrder->update([
            'tracking_number' => $request->tracking_number,
            'status' => 'shipped', // Automatically set status to shipped
        ]);

        return back()->with('success', 'Tracking number updated successfully.');
    }

    /**
     * Delete a gift order.
     */
    public function destroy($id)
    {
        $giftOrder = GiftOrder::findOrFail($id);

        // Only allow deletion of cancelled orders
        if ($giftOrder->status !== 'cancelled') {
            return back()->with('error', 'Only cancelled orders can be deleted.');
        }

        $giftOrder->delete();

        return back()->with('success', 'Gift order deleted successfully.');
    }
}
