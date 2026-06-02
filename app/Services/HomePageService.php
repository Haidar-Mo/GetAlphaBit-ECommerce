<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

/**
 * Class HomePageService.
 */
class HomePageService
{
    public function index()
    {
        $data = [
            'sliders' => Slider::latest()->take(5)->get(),
            'featured_product' => Product::with(['category', 'media', 'sales'])
                ->orderByDesc('reviews')
                ->take(8)
                ->get(),
            'latest_product' => Product::with(['category', 'media', 'sales'])
                ->latest()
                ->take(8)
                ->get(),
            'product_with_active_sales' => Product::with(['category', 'media', 'sales'])
                ->whereHas('sales', function ($q) {
                    $q->where('is_active', true);
                })
                ->take(8)
                ->get(),
            'product_with_black_color' => Product::with(['category', 'media', 'sales'])
                ->whereHas('attributes', function ($q) {
                    $q->where('name', 'color')->where('value', 'like', 'black');
                })->latest()->take(5)->get()
        ];

        return $data;
    }
}
