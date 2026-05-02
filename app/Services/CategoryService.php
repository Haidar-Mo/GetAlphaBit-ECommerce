<?php

namespace App\Services;

use App\Models\Category;

/**
 * Class CategoryService.
 */
class CategoryService
{
    public function index()
    {
        $categories = Category::with([
            'parent',
            'children'
        ])->latest()->get();

        return $categories;
    }
    public function show($id)
    {
        $category = Category::with([
            'parent',
            'children',
            'products.media',
            'products.sales',
        ])->findOrFail($id);

        return $category;
    }
}
