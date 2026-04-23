<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use App\Models\Sale;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Media;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  //  use WithoutModelEvents; //: this will prevent model events from being fired during seeding (Like booted method)

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::factory(10)->create();

    Category::factory()
      ->count(2)
      ->has(
        Product::factory(3)
          ->has(ProductAttribute::factory(6), 'attributes')
          ->has(Media::factory(3), 'media')
          ->has(Review::factory(5), 'reviews')
          ->hasAttached(
            Sale::factory(1),
            [
              'discount_ratio' => 10,
              'discount_price' => 25,
            ]
          )
        ,
        'products'
      )->create();

  }
}