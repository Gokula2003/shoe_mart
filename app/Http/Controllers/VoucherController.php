<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Apply voucher to order.
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:vouchers,code',
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid voucher code.'
            ], 404);
        }

        if (!$voucher->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher is no longer valid or has already been used.'
            ], 400);
        }

        // Store voucher in session
        session(['applied_voucher' => $voucher->code]);

        return response()->json([
            'success' => true,
            'message' => 'Voucher applied successfully!',
            'voucher' => [
                'code' => $voucher->code,
                'amount' => $voucher->amount,
            ]
        ]);
    }

    /**
     * Remove applied voucher.
     */
    public function remove()
    {
        session()->forget('applied_voucher');

        return response()->json([
            'success' => true,
            'message' => 'Voucher removed.'
        ]);
    }

    /**
     * Get user's vouchers.
     */
    public function myVouchers()
    {
        $vouchers = Voucher::where('purchased_by', auth()->id())
            ->orWhere('used_by', auth()->id())
            ->latest()
            ->get();

        return view('vouchers.my-vouchers', compact('vouchers'));
    }
}
