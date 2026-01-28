<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Models\Admin;

class OrderPolicy
{
    /**
     * Determine if the user can view the order.
     */
    public function view(?User $user, Order $order): bool
    {
        // Allow viewing if user owns the order
        if ($user && $order->user_id === $user->id) {
            return true;
        }

        // Allow viewing if order matches user's email (guest orders)
        if ($user && $order->customer_email === $user->email) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can update the order.
     */
    public function update(?User $user, Order $order): bool
    {
        // Admins can update/cancel any order
        if ($user instanceof Admin) {
            return true;
        }

        // Users can only cancel their own pending orders
        if ($user && $order->user_id === $user->id && $order->status === 'pending') {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete/cancel the order.
     */
    public function delete(?User $user, Order $order): bool
    {
        // Admins can delete/cancel any order
        if ($user instanceof Admin) {
            return true;
        }

        // Users can only cancel their own pending orders
        if ($user && $order->user_id === $user->id && $order->status === 'pending') {
            return true;
        }

        return false;
    }

    /**
     * Determine if admin can manage any order.
     */
    public function manageAny($user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine if admin can update any order.
     */
    public function updateAny($user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine if admin can delete any order.
     */
    public function deleteAny($user): bool
    {
        return $user instanceof Admin;
    }
}
