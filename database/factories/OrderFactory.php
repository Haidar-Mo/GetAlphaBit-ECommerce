<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->numberBetween(100, 1000);

        $shipping = 20;

        $discount = fake()->numberBetween(0, 100);
        return [
            'user_id' => User::factory(),

            'shipping_address' => fake()->address(),

            'order_number' => 'ORD-' . strtoupper(fake()->unique()->bothify('#####')),

            'subtotal' => $subtotal,

            'shipping_cost' => $shipping,

            'discount_amount' => $discount,

            'total' => ($subtotal + $shipping) - $discount,

            'status' => fake()->randomElement(array_column(OrderStatus::cases(), 'value')),
            'payment_status' => fake()->randomElement(array_column(PaymentStatus::cases(), 'value')),
            'payment_method' => fake()->randomElement(array_column(PaymentMethod::cases(), 'value')),
        ];

    }
}
