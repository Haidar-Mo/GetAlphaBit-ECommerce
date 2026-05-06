<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'slug' => $this->product->slug,
            'price' => $this->product->price,
            'discount_ratio' => $this->product->discount_ratio,
            'discount_price' => $this->product->discount_price,
        ];
    }
}
