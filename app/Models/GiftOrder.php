<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_name',
        'recipient_email',
        'recipient_phone',
        'recipient_address',
        'product_id',
        'quantity',
        'total_amount',
        'gift_message',
        'status',
        'tracking_number',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user who sent this gift.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the product being gifted.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
