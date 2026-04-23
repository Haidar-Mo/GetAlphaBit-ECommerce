<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = $this->faker->unique()->words(3, true);
        $brand = fake()->company();
        return [
            'category_id' => Category::factory(),
            'name' => $name,
            /*             'slug' => Str::slug($name),
                        'sky' => $name . '-' . $brand, */
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'brand' => $brand,
            'is_available' => true
        ];
    }
}