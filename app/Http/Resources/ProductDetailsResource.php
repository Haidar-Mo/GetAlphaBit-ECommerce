<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
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
            'description' => $this->description,
            'brand' => $this->brand,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'discount_ratio' => $this->discount_ratio,
            'is_available' => $this->is_available,
            'reviews' => $this->reviews,
            'reviews_count' => $this->reviews_count,
            'is_favorite' => $this->is_favorite,
            'hero_image' => $this->media->where('is_hero', true)->first()->only(['id', 'path']),
            'media' => $this->media->where('is_hero', false)->values()->map(function ($media) {
                return [
                    'id' => $media->id,
                    'path' => $media->path,
                ];
            }),
            'attributes' => $this->attributes->map(function ($attribute) {
                return [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'value' => $attribute->value
                ];
            }),
            'category' => $this->category,
            'related_products' => $this->category->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                ];
            }),
        ];
    }
}
