<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Models\Admin;

class ProductPolicy
{
    /**
     * Determine if anyone can view products.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine if anyone can view a single product.
     */
    public function view(?User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Determine if the user can create products (admin only).
     */
    public function create($user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine if the user can update products (admin only).
     */
    public function update($user, Product $product): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine if the user can delete products (admin only).
     */
    public function delete($user, Product $product): bool
    {
        return $user instanceof Admin;
    }
}
