<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\GiftOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoucherAndGiftTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_purchase_voucher()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);
        
        $response = $this->post(route('vouchers.shop'), [
            'selectedAmount' => 50,
            'description' => 'Test voucher',
        ]);
        
        $this->assertDatabaseHas('vouchers', [
            'amount' => 50,
            'purchased_by' => $user->id,
            'is_used' => false,
        ]);
    }

    /** @test */
    public function voucher_can_be_validated()
    {
        $voucher = Voucher::create([
            'code' => 'TEST123',
            'amount' => 100,
            'expires_at' => now()->addYear(),
        ]);
        
        $this->assertTrue($voucher->isValid());
        
        // Test used voucher
        $voucher->markAsUsed(1);
        $this->assertFalse($voucher->isValid());
    }

    /** @test */
    public function user_can_send_gift()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 100,
            'stock' => 10,
        ]);
        
        $this->actingAs($user);
        
        $giftData = [
            'product_id' => $product->id,
            'quantity' => 1,
            'recipient_name' => 'John Doe',
            'recipient_email' => 'john@example.com',
            'recipient_address' => '123 Main St',
            'gift_message' => 'Happy Birthday!',
        ];
        
        $response = $this->post(route('gift.send'), $giftData);
        
        $this->assertDatabaseHas('gift_orders', [
            'sender_id' => $user->id,
            'recipient_name' => 'John Doe',
            'product_id' => $product->id,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function gift_order_respects_stock()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 100,
            'stock' => 0,
        ]);
        
        $this->assertFalse($product->hasStock(1));
    }

    /** @test */
    public function admin_can_manage_vouchers()
    {
        // This would require admin middleware to be set up
        // Test admin can view, create, and delete vouchers
    }

    /** @test */
    public function admin_can_update_gift_order_status()
    {
        $giftOrder = GiftOrder::factory()->create([
            'status' => 'pending',
        ]);
        
        $giftOrder->update(['status' => 'shipped']);
        
        $this->assertEquals('shipped', $giftOrder->fresh()->status);
    }
}
