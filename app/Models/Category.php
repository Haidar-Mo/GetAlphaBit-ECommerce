<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];

    protected static function booted(){
        static::creating(function($category){
            $category->slug = str($category->name)->lower()->trim()->replace(' ','_');
        });
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class , 'parent_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}