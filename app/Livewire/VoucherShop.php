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

        // Generate unique voucher code
        $code = 'VC-' . strtoupper(Str::random(8));

        // Create voucher
        $voucher = Voucher::create([
            'code' => $code,
            'amount' => $this->selectedAmount,
            'description' => $this->description,
            'purchased_by' => auth()->id(),
            'expires_at' => now()->addYear(),
        ]);

        session()->flash('message', 'Voucher purchased successfully! Your voucher code is: ' . $voucher->code);
        
        // Reset form
        $this->reset(['selectedAmount', 'customAmount', 'description']);
        
        return redirect()->route('vouchers.success', ['voucher' => $voucher->id]);
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
