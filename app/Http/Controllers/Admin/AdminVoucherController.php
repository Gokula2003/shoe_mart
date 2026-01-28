<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class AdminVoucherController extends Controller
{
    /**
     * Display all vouchers.
     */
    public function index(Request $request)
    {
        $query = Voucher::with(['purchaser', 'user']);

        // Filter by status
        if ($request->has('filter')) {
            if ($request->filter === 'used') {
                $query->where('is_used', true);
            } elseif ($request->filter === 'unused') {
                $query->where('is_used', false)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
            } elseif ($request->filter === 'expired') {
                $query->where('expires_at', '<', now())
                    ->where('is_used', false);
            }
        }

        // Search by code
        if ($request->has('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        $vouchers = $query->latest()->paginate(20);

        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Create a new voucher (manually).
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store a new voucher.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:500',
            'expires_at' => 'nullable|date|after:today',
        ]);

        Voucher::create([
            'code' => strtoupper($request->code),
            'amount' => $request->amount,
            'description' => $request->description,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher created successfully.');
    }

    /**
     * Delete a voucher.
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);

        // Prevent deletion of used vouchers
        if ($voucher->is_used) {
            return back()->with('error', 'Cannot delete a used voucher.');
        }

        $voucher->delete();

        return back()->with('success', 'Voucher deleted successfully.');
    }

    /**
     * Manually mark voucher as used.
     */
    public function markAsUsed($id)
    {
        $voucher = Voucher::findOrFail($id);

        if ($voucher->is_used) {
            return back()->with('error', 'Voucher is already used.');
        }

        $voucher->update([
            'is_used' => true,
            'used_at' => now(),
        ]);

        return back()->with('success', 'Voucher marked as used.');
    }
}
