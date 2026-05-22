<?php

namespace App\Models;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shipping_address',
        'order_number',
        'subtotal',
        'shipping_cost',
        'discount_amount',
        'total',
        'status',
        'payment_status',
        'payment_method'
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class
    ];

    public function orderItems()
    {
        $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

}
