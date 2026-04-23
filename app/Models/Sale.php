<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'is_active'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sales')
            ->withPivot(['discount_ratio', 'discount_price']);
    }
}