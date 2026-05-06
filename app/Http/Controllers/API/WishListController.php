<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishList;
use App\Traits\FormattedResponse;
use Exception;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    use FormattedResponse;
    public function index()
    {
        try {
            $wishLists = WishList::with('product')->where('user_id', auth()->id())->latest()->get();
            return $this->success(
                $wishLists,
                'wish lists retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function toggleWishList($id)
    {
        $wish = WishList::where('user_id', auth()->id())->where('product_id', $id)->first();

        if ($wish) {
            $wish->delete();

            return response()->json([
                'status' => true,
                'message' => 'product removed form Wish List successfully',
                'is_favorite' => false
            ]);
        }
        auth()->user()->wishLists()->create([
            'product_id' => $id
        ]);
        return response()->json([
            'status' => true,
            'message' => 'product added to Wish List successfully',
            'is_favorite' => true
        ]);
    }
}
