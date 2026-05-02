<?php

namespace App\Services;

use App\Filters\ProductFilter;
use App\Models\Product;

/**
 * Class ProductService.
 */
class ProductService
{
    public function index(ProductFilter $filter)
    {
        $query = Product::with(['sales', 'media', 'attributes']);

        $product = $filter->applyFilters($query)->latest()->paginate(10);

        return $product;
    }

    public function show($id)
    {
        $product = Product::with([
            'media',
            'attributes',
            'sales',
            'reviews'
        ])->findOrFail($id);

        return $product;
    }
}
