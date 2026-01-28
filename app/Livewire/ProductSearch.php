<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductSearch extends Component
{
    public $search = '';
    public $category = '';
    public $minPrice = '';
    public $maxPrice = '';

    public function render()
    {
        $query = Product::query();

        // Search by name or description
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by category
        if ($this->category) {
            $query->where('category', $this->category);
        }

        // Filter by price range
        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }

        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        $products = $query->where('stock', '>', 0)
                          ->orderBy('created_at', 'desc')
                          ->get();

        $categories = Product::select('category')
                             ->distinct()
                             ->pluck('category');

        return view('livewire.product-search', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->minPrice = '';
        $this->maxPrice = '';
    }
}
