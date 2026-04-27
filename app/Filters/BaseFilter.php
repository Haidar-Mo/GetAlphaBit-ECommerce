<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Str;

class BaseFilter
{
    public function __construct(protected Request $request)
    {
    }

    /*
    : This method is responsible for applying the filters to the query.
    : It gets all the query parameters from the request, converts the keys to camel case,
    : and checks if a method exists for each filter.
    : If a method exists, it applies the filter to the query.
    */
    public function applyFilters(Builder $query): Builder
    {
        //: get Parameters from the request
        $parameters = $this->request->query();

        foreach ($parameters as $key => $value) {
            //: convert the key to camel case, Then check if a method exists for the filter, if it does, apply the filter
            $filter = Str::camel($key);

            if (method_exists($this, $filter)) {
                $query = $this->$filter($query); //^ $filter equal to the method name that we want to apply, so here we call the method 
            }
        }

        return $query;
    }
}
