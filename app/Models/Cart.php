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
        // 'status' => CartStatus::class
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function coupon()
    {
        $this->belongsTo(Coupon::class);
    }

    public function cartItems()
    {
        $this->hasMany(CartItem::class);
    }

}
