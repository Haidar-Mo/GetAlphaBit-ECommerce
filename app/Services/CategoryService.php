<?php

namespace App\Services;

use App\Models\Category;

/**
 * Class CategoryService.
 */
class CategoryService
{

    /*
    : (Keep this method just for you) 
    : You do not need to eager load (call) "parent" relation, children is enough
    : and you do not need to retrieve all the relations in the "index" method,
    : instead of that, you can create "showWithParent" and "showWithChildren" methods 
    : This will make the front-end more comfortable then return all data in one methods
    */
    public function index()
    {
        $categories = Category::with([
            'parent',
            'children'
        ])->latest()->get();

        return $categories;
    }

    /*
    : here you are eager load all the products with their stuff, this is not the real purpose of the method
    : the real purpose of the method is to return the category with its children
    : this core logic belongs to Products methods, (get all products where category_id = $id)
    */
    public function show($id)
    {
        $category = Category::with([
            'parent',
            'children',
        ])->findOrFail($id);

        return $category;
    }

    //: All the main categories
    public function indexWithChildren()
    {
        $category = Category::where('parent_id', null)->with([
            'children',
        ])->get();

        return $category;
    }

    //: All the sub categories
    public function indexWithParent()
    {
        $category = Category::where('parent_id', '!=', null)->with([
            'parent',
        ])->get();

        return $category;
    }


}
