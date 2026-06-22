<?php

namespace App\Services;

use App\Enums\CartStatus;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use ReturnTypeWillChange;

/**
 * Class CartService.
 */
class CartService
{
    public function addToCart($user, $data)
    {
        $cart = Cart::firstOrCreate(
            [
                'user_id' => $user->id,
                'status' => CartStatus::ACTIVE
            ]
        );

        $product = Product::findOrFail($data['product_id']);

        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $data['quantity']);
            $cartItem->update([
                'subtotal' => $cartItem->price * $cartItem->quantity
            ]);
        } else {
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $data['quantity']
            ]);
        }

        return $cart->load([
            'cartItems.product.media',
            'coupon'
        ]);
    }
    public function updateQuantity(CartItem $cartItem, $quantity)
    {
        $cartItem->update([
            'quantity' => $quantity,
            'subtotal' => $cartItem->price * $quantity
        ]);

        return $cartItem;
    }

    public function removeItem(CartItem $cartItem)
    {
        return $cartItem->delete();
    }

    public function applyCoupon($user, $code)
    {
        $cart = Cart::where('user_id', $user->id)
            ->where('status', CartStatus::ACTIVE)
            ->firstOrFail();

        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        $cart->update([
            'coupon_id' => $coupon->id
        ]);

        return $cart;
    }

    public function cancelCart($user)
    {
        $cart = Cart::where('user_id', $user->id)
            ->where('status', CartStatus::ACTIVE)
            ->firstOrFail();

        $cart->update([
            'status' => CartStatus::ABANDONED
        ]);
    }

}
