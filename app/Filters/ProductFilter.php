<?php

namespace App\Filters;

use Illuminate\DataBase\Eloquent\Builder;

class ProductFilter extends BaseFilter
{
    public function name(Builder $query)
    {
        return $query->where('name', 'like', '%' . request('name') . '%');
    }

    public function category(Builder $query)
    {
        return $query->where('category_id', request('category'));
    }

    public function minPrice(Builder $query)
    {
        return $query->where('price', '>=', request()->input('minPrice'));
    }
    public function maxPrice(Builder $query)
    {
        return $query->where('price', '<=', request()->input('maxPrice'));
    }

    public function availability(Builder $query)
    {
        return $query->where('is_available', request('availability'));
    }

    public function activeSale(Builder $query)
    {
        return $query->whereHas('sales', function ($q) {
            $q->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        });
    }


}