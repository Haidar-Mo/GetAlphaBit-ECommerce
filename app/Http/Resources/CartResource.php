<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $subtotal = $this->cartItem->sum('subtotal');
        $discount = 0;

        if ($this->coupon) {
            if ($this->coupon->type == 'fixed') {
                $discount = $this->coupon->value;
            } else {
                $discount = ($subtotal * $this->coupon->value) / 100;
            }
        }
        return [
            'id' => $this->id,
            'status' => $this->status->value,
            'coupon' => new CouponResource($this->whenLoaded('coupon')),
            'items' => CartItemResource::collection($this->whenLoaded('cartItems')),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal - $discount,
            'created_at' => $this->created_at
        ];
    }
}
