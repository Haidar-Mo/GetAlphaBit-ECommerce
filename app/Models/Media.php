<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'is_hero'
    ];

    public function mediaable(){
        return $this->morphTo();
    }
}