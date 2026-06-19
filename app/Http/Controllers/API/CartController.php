<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\UpdatCartRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Services\CartService;
use App\Traits\FormattedResponse;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use FormattedResponse;

    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(AddToCartRequest $request)
    {
        try {
            $cart = $this->cartService->addToCart(auth()->user(), $request);

            return $this->success(
                new CartResource($cart),
                'Product added successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function update(UpdatCartRequest $request, CartItem $cartItem)
    {
        try {
            $newCartItem = $this->cartService->updateQuantity($cartItem, $request->quantity);
            return $this->success(
                new CartItemResource($newCartItem),
                'Quantity updated successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }

    }

    public function removeItem(CartItem $cartItem)
    {
        return $this->cartService->removeItem($cartItem);
    }

    public function applyCoupon(ApplyCouponRequest $request)
    {
        $cart = $this->cartService->applyCoupon(auth()->user(), $request->code);

        return new CartResource($cart->load(['cartItems.product.media', 'coupon']));
    }

    public function cancel()
    {
        return $this->cartService->cancelCart(auth()->user());
    }
}
