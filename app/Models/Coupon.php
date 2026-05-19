<?php

namespace App\Models;

use App\Enums\CouponType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_order_amount',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'type' => CouponType::class,
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];
    public function carts()
    {
        $this->hasMany(Cart::class);
    }
}
