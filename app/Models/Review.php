<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'review'
    ];

    protected static function booted(){
        static::creating(function($review){
            $product = $review->product;

            $product->reviews = $product->reviews()?->avg('review') ? : 0.0;
            $product->reviews_count = $product->reviews()->count();

            $product->save();
        });
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}