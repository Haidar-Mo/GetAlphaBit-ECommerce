<?php

namespace App\Http\Controllers\API;

use App\Filters\ProductFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Traits\FormattedResponse;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use FormattedResponse;

    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(ProductFilter $filter)
    {
        try {
            $products = $this->productService->index($filter);
            return $this->success(
                ProductResource::collection($products),
                'Products Retrieved Successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }
    public function show($id)
    {
        try {
            $product = $this->productService->show($id);
            return $this->success(
                new ProductDetailsResource($product),
                'Product Retrieved Successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }
}
