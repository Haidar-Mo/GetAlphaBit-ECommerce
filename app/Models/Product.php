<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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

    protected $appends = ['discount_price', 'discount_ratio'];

    protected static function booted(){
        static::creating(function ($product){
            $product->slug = str::slug($product->name);
            $color = $product->attributes()->where('name','color')->value('value');
            $size = $product->attributes()->where('name','size')->value('value');

            $product->sky = strtoupper(
                $product->name . "-" . $product->brand . "-" . ($color ?? 'na') . "-" . ($size ?? 'na')
            );
        });

    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function media(){
        return $this->morphMany(Media::class, 'mediaable');
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class)->withPivot(['discount_ratio', 'discount_price']);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function getDiscountPriceAttribute()
    {
        $sale = $this->sales->where('is_active', true)->first();

        return $sale?->pivot->discount_price;
        /* if ($sale) {
            return $sale->pivot->discount_price;
        } else {
            return null;
        } */
    }

    public function getDiscountRatioAttribute()
    {
        $sale = $this->sales->where('is_active', true)->first();
        return  $sale?->pivot->discount_ratio;

        /* if ($sale) {
            return $sale->pivot->discount_price;
        } else {
            return null;
        } */
    }
}