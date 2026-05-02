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
            'fetured_product' => Product::with(['media', 'sales'])
                ->orderByDesc('reviews')
                ->take(8)
                ->get(),
            'latest_product' => Product::with(['media', 'sales'])
                ->latest()
                ->take(8)
                ->get(),
            'product_with_active_sales' => Product::with(['media', 'sales'])
                ->whereHas('sales', function ($q) {
                    $q->where('is_active', true);
                })
                ->take(8)
                ->get(),
            'categories' => Category::with('children')->get()
        ];

        return $data;
    }
}
