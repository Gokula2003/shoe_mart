<?php

namespace App\Livewire;

use App\Models\Voucher;
use Illuminate\Support\Str;
use Livewire\Component;

class VoucherShop extends Component
{
    public $selectedAmount = null;
    public $customAmount = null;
    public $description = '';
    public $voucherAmounts = [25, 50, 100, 200, 500];

    protected $rules = [
        'selectedAmount' => 'required|numeric|min:10',
        'description' => 'nullable|string|max:500',
    ];

    public function selectAmount($amount)
    {
        $this->selectedAmount = $amount;
        $this->customAmount = null;
    }

    public function setCustomAmount()
    {
        if ($this->customAmount && $this->customAmount >= 10) {
            $this->selectedAmount = $this->customAmount;
        }
    }

    public function purchaseVoucher()
    {
        $this->validate();

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Store voucher data in session and redirect to billing page
        session([
            'voucher_purchase' => [
                'amount' => $this->selectedAmount,
                'description' => $this->description,
            ]
        ]);

        return redirect()->route('vouchers.billing');
    }

    public function render()
    {
        $myVouchers = auth()->check() 
            ? Voucher::where('purchased_by', auth()->id())
                ->orWhere('used_by', auth()->id())
                ->latest()
                ->get()
            : collect();

        return view('livewire.voucher-shop', [
            'myVouchers' => $myVouchers,
        ])->layout('layouts.public');
    }
}
