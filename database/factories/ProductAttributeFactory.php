<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductAttribute>
 */
class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement(['color', 'size']);
        $value = match ($name) {
            'color' => fake()->safeColorName(),
            'size' => fake()->randomElement(['XS', 'S', 'M', 'L', 'XL']),
        };
        return [
            'product_id' => Product::factory(),
            'name' => $name,
            'value' => $value
        ];
    }
}
