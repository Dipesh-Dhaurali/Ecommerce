<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'order_type',
        'status',
        'subtotal',
        'total',
        'payment_status',
        'payment_method',
        'payment_screenshot',
        'refund_requested',
        'refund_reason',
        'refund_requested_at',
        'refund_status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected $casts = [
        'refund_requested_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
