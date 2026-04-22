<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Media;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Category::factory()
                ->count(2)
                ->has(Product::factory(3)
                ->has(Media::factory(3),'media')
                ->has(Review::factory(5),'reviews'),'products')->create();

    }
}