<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Traits\FormattedResponse;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use FormattedResponse;
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        try {
            $categories = $this->categoryService->index();
            return $this->success(
                CategoryResource::collection($categories),
                'Categories retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function indexWithChildren()
    {
        try {
            $categories = $this->categoryService->indexWithChildren();
            return $this->success(
                $categories,
                'Categories with children retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function indexWithParent()
    {
        try {
            $categories = $this->categoryService->indexWithParent();
            return $this->success(
                $categories,
                'Categories with parent retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryService->show($id);
            return $this->success(
                new CategoryResource($category),
                'Category retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

}
