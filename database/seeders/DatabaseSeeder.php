<?php

namespace Database\Seeders;

/* use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem; */
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductAttribute;
use App\Models\Sale;
/* use App\Models\Slider;
use App\Models\User;
use App\Models\Category; */
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
    /*     User::factory()->isAdmin()->create();
        User::factory(10)->create();
        Slider::factory(15)->create(); */

    $this->call(CategorySeeder::class);

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
      )->create();

    Coupon::factory(5)->create();

    Cart::factory(30)
      ->create()
      ->each(function ($cart) {

        CartItem::factory(rand(1, 5))
          ->create([
            'cart_id' => $cart->id
          ]);
      });

    Order::factory(50)
      ->create()
      ->each(function ($order) {

        OrderItem::factory(rand(1, 5))
          ->create([
            'order_id' => $order->id
          ]);
      });

  }
}