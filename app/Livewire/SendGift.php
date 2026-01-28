<?php

namespace App\Livewire;

use App\Models\GiftOrder;
use App\Models\Product;
use Livewire\Component;

class SendGift extends Component
{
    public $product_id;
    public $product;
    public $quantity = 1;
    public $recipient_name;
    public $recipient_email;
    public $recipient_phone;
    public $recipient_address;
    public $gift_message;
    
    public $showProductSelection = true;
    public $searchTerm = '';

    protected $rules = [
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'recipient_name' => 'required|string|max:255',
        'recipient_email' => 'required|email|max:255',
        'recipient_phone' => 'nullable|string|max:20',
        'recipient_address' => 'required|string|max:1000',
        'gift_message' => 'nullable|string|max:500',
    ];

    public function mount($productId = null)
    {
        if ($productId) {
            $this->product_id = $productId;
            $this->product = Product::find($productId);
            $this->showProductSelection = false;
        }
    }

    public function selectProduct($productId)
    {
        $this->product_id = $productId;
        $this->product = Product::find($productId);
        $this->showProductSelection = false;
    }

    public function changeProduct()
    {
        $this->showProductSelection = true;
        $this->product = null;
        $this->product_id = null;
    }

    public function sendGift()
    {
        $this->validate();

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $product = Product::findOrFail($this->product_id);
        
        // Check stock availability
        if (!$product->hasStock($this->quantity)) {
            session()->flash('error', 'Insufficient stock. Only ' . $product->stock . ' items available.');
            return;
        }
        
        $totalAmount = $product->price * $this->quantity;

        // Create gift order
        $giftOrder = GiftOrder::create([
            'sender_id' => auth()->id(),
            'recipient_name' => $this->recipient_name,
            'recipient_email' => $this->recipient_email,
            'recipient_phone' => $this->recipient_phone,
            'recipient_address' => $this->recipient_address,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'total_amount' => $totalAmount,
            'gift_message' => $this->gift_message,
            'status' => 'pending',
        ]);

        // Optionally reduce stock
        // $product->decrement('stock', $this->quantity);

        session()->flash('message', 'Gift order placed successfully! The recipient will receive their gift soon.');
        
        return redirect()->route('gift.success', ['giftOrder' => $giftOrder->id]);
    }

    public function render()
    {
        $products = collect();
        
        if ($this->showProductSelection) {
            $query = Product::query();
            
            if ($this->searchTerm) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
                });
            }
            
            $products = $query->paginate(12);
        }

        return view('livewire.send-gift', [
            'products' => $products,
        ])->layout('layouts.public');
    }
}
