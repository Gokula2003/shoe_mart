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

    /**
     * Show billing page for voucher purchase.
     */
    public function showBilling()
    {
        if (!session()->has('voucher_purchase')) {
            return redirect()->route('vouchers.shop')->with('error', 'Please select a voucher first.');
        }

        $voucherData = session('voucher_purchase');
        return view('vouchers.billing', compact('voucherData'));
    }

    /**
     * Process billing and create voucher.
     */
    public function processBilling(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
            'email' => 'required|email|max:255',
            'card_number' => 'required|digits:16',
            'card_holder' => 'required|string|max:255',
            'expiry_month' => 'required|digits:2|min:1|max:12',
            'expiry_year' => 'required|integer|min:' . date('Y'),
            'cvv' => 'required|digits:3',
        ]);

        if (!session()->has('voucher_purchase')) {
            return redirect()->route('vouchers.shop')->with('error', 'Session expired. Please try again.');
        }

        $voucherData = session('voucher_purchase');

        // Generate unique voucher code
        $code = 'VC-' . strtoupper(\Illuminate\Support\Str::random(8));

        // Create voucher
        $voucher = Voucher::create([
            'code' => $code,
            'amount' => $voucherData['amount'],
            'description' => $voucherData['description'],
            'purchased_by' => auth()->id(),
            'expires_at' => now()->addYear(),
        ]);

        // Clear session
        session()->forget('voucher_purchase');

        return redirect()->route('vouchers.success', ['voucher' => $voucher->id])
            ->with('success', 'Voucher purchased successfully! Your voucher code is: ' . $voucher->code);
    }
}
