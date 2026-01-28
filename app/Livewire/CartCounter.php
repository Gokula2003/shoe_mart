<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartCounter extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        if (Auth::check()) {
            $this->cartCount = CartItem::where('user_id', Auth::id())->count();
        } else {
            $this->cartCount = CartItem::where('session_id', session()->getId())->count();
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
