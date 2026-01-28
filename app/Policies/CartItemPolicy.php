<?php

namespace App\Policies;

use App\Models\CartItem;
use App\Models\User;

class CartItemPolicy
{
    /**
     * Determine if the user can view the cart item.
     */
    public function view(?User $user, CartItem $cartItem): bool
    {
        if (!$user) {
            return $cartItem->session_id === session()->getId();
        }

        return $cartItem->user_id === $user->id || $cartItem->session_id === session()->getId();
    }

    /**
     * Determine if the user can delete the cart item.
     */
    public function delete(?User $user, CartItem $cartItem): bool
    {
        if (!$user) {
            return $cartItem->session_id === session()->getId();
        }

        return $cartItem->user_id === $user->id;
    }

    /**
     * Determine if the user can update the cart item.
     */
    public function update(?User $user, CartItem $cartItem): bool
    {
        if (!$user) {
            return $cartItem->session_id === session()->getId();
        }

        return $cartItem->user_id === $user->id;
    }
}
