<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->numberBetween(50, 500);
        $quantity = fake()->numberBetween(1, 5);
        return [
            'cart_id' => Cart::factory(),
            'product_id' => Product::inRandomOrder()->value('id'),
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $price * $quantity
        ];
    }
}
