<?php

namespace Database\Factories;

use App\Enums\CouponType;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('SALE-###')),
            'type' => fake()->randomElement(CouponType::cases()),
            'value' => fake()->numberBetween(5, 50),
            'minimum_order_amount' => fake()->numberBetween(100, 500),
            'usage_limit' => fake()->numberBetween(10, 100),
            'used_count' => fake()->numberBetween(0, 10),
            'expires_at' => now()->addDays(rand(5, 30)),
            'is_active' => true
        ];
    }
}
