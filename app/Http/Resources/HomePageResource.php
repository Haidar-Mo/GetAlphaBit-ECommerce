<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sliders' => collect($this['sliders'])->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'image_path' => asset($slider->image_path),
                ];
            }),

            'featured_product' => ProductResource::collection(
                $this['featured_product']
            ),

            'latest_product' => ProductResource::collection(
                $this['latest_product']
            ),

            'product_with_active_sales' => ProductResource::collection(
                $this['product_with_active_sales']
            ),

            'categories' => CategoryResource::collection(
                $this['categories']
            ),
        ];
    }
}
