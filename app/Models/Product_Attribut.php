<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Product_Attribut extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'value'
    ];

    public function product(){
        return $this->belongTo(Product::class);
    }
}