<?php

namespace App\Models;
use App\Enums\CartStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'coupon_id'
    ];

    protected $casts = [
        'status' => CartStatus::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

}
