<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $product;
    public $quantity = 1;
    public $size = '';
    public $availableSizes = ['US 6', 'US 7', 'US 8', 'US 9', 'US 10', 'US 11', 'US 12'];
    public $showSuccess = false;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function increment()
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $this->validate([
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1|max:' . $this->product->stock,
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id,
            'quantity' => $this->quantity,
            'size' => $this->size,
            'session_id' => session()->getId(),
        ]);

        $this->showSuccess = true;
        $this->dispatch('cartUpdated');

        // Reset form
        $this->quantity = 1;
        $this->size = '';

        // Hide success message after 3 seconds
        $this->dispatch('hideSuccess');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
