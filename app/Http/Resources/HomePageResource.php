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
            'categories' => CategoryResource::collection($this['categories']),

            'product_with_active_sales' => ProductResource::collection($this['product_with_active_sales']),

            'most_reviewed_products' => ProductResource::collection($this['most_reviewed_products']),

            'latest_products' => ProductResource::collection($this['latest_products']),

            'featured_products' => ProductResource::collection($this['featured_products']),


        ];
    }
}
