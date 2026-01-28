<?php

namespace App\Http\Controllers;

use App\Models\GiftOrder;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    /**
     * Display user's sent gifts.
     */
    public function mySentGifts()
    {
        $sentGifts = GiftOrder::where('sender_id', auth()->id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('gift.my-sent-gifts', compact('sentGifts'));
    }

    /**
     * Display gift details.
     */
    public function show($id)
    {
        $giftOrder = GiftOrder::with('product', 'sender')
            ->findOrFail($id);

        // Check authorization
        if ($giftOrder->sender_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('gift.show', compact('giftOrder'));
    }

    /**
     * Cancel a gift order.
     */
    public function cancel($id)
    {
        $giftOrder = GiftOrder::findOrFail($id);

        // Check authorization
        if ($giftOrder->sender_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow cancellation if order is still pending
        if ($giftOrder->status !== 'pending') {
            return back()->with('error', 'Cannot cancel order that is already being processed.');
        }

        $giftOrder->update(['status' => 'cancelled']);

        return back()->with('success', 'Gift order cancelled successfully.');
    }
}
