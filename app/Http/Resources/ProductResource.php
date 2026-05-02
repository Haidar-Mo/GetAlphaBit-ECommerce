<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sky' => $this->sky,
            'brand' => $this->brand,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'discount_ratio' => $this->discount_ratio,
            'is_available' => $this->is_available,
            'hero_image' => $this->media->where('is_hero', true)->first(),
        ];
    }
}
