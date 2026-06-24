<?php

namespace App\Services;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentService;
use Str;


class OrderService
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    public function checkOut($user, $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $cart = Cart::with('cartItems')->where('user_id', $user->id)->where('status', CartStatus::ACTIVE)->firstOrFail();

            $subtotal = $cart->cartItems()->sum('subtotal');
            $discount = 0;
            $shipping = 20;

            if ($cart->coupon) {
                if ($cart->coupon->type->value == 'fixed') {
                    $discount = $cart->coupon->value;
                } else {
                    $discount = ($subtotal * $cart->coupon->value) / 100;
                }
            }

            $total = ($subtotal + $shipping) - $discount;

            $order = Order::create([
                'user_id' => $user->id,
                'shipping_address' => $data['shipping_address'],
                'order_number' => 'ORD-' . strtoupper(Str::random(5)),
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'discount_amount' => $discount,
                'total' => $total,
                'status' => OrderStatus::PENDING,
                'payment_status' => PaymentStatus::PENDING,
                'payment_method' => $data['payment_method'],
            ]);

            foreach ($cart->cartItems as $item) {
                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);
            }

            $cart->update([
                'status' => CartStatus::CONVERTED,
            ]);

            $clientSecret = null;

            if ($order->payment_method === PaymentMethod::STRIPE) {
                $intent = $this->paymentService->createPaymentIntent($order->total);

                $order->update([
                    'stripe_payment_intent_id' => $intent->id,
                ]);

                $clientSecret = $intent->client_secret;
            }

            return [
                'order' => $order,
                'client_secret' => $clientSecret,
            ];
        });
    }
}
