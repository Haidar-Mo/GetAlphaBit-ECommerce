<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sales;
use App\Models\Product_Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sky',
        'description',
        'price',
        'brand',
        'is_available'
    ];

    protected $appends = ['final_price'];

    protected static function booted(){
        static::creating(function ($product){
            $product->slug = str($product->name)->lower()->trim()->replace(' ','_');
            $color = $product->attributes()->where('name','color')->value('value');
            $size = $product->attributes()->where('name','size')->value('value');

            $product->sky = strtoupper(
                $product->name . $product->brand . ($color ?? '') . ($size ?? '')
            );
        });

    }

    public function attributes(){
        return $this->hasMany(Product_Attribute::class);
    }

    public function media(){
        return $this->morphMany(Media::class, 'mediaable');
    }
    public function sales(){
        return $this->belongsToMany(Sales::class)->withPivot(['discount_ratio','discount_price']);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function getFinalPriceAttribute(){
        $sale = $this->sales()->where('is_active', true)->first();
        if(!$sale){
            return $this->price;
        }
        else{
            return $this->price - ($this->price * $sale->pivot->discount_ratio /100);
        }
    }
}