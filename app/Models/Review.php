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

            $product->reviews = $product->reviewsRelation()->avg('review');
            $product->reviews_count = $product->reviewsRelation()->count();

            $product->save();
        });
    }

    public function product(){
        return $this->belongTo(Product::class);
    }
    public function user(){
        return $this->belongTo(User::class);
    }
}