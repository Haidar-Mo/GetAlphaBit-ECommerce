<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Camera',
                'slug' => 'camera',
                'icon' => 'icons/category/Category-Camera.png',
            ],
            [
                'name' => 'Cell Phone',
                'slug' => 'cell-phone',
                'icon' => 'icons/category/Category-CellPhone.png',
            ],
            [
                'name' => 'Computer',
                'slug' => 'computer',
                'icon' => 'icons/category/Category-Computer.png',
            ],
            [
                'name' => 'Gamepad',
                'slug' => 'gamepad',
                'icon' => 'icons/category/Category-Gamepad.png',
            ],
            [
                'name' => 'Headphone',
                'slug' => 'headphone',
                'icon' => 'icons/category/Category-Headphone.png',
            ],
            [
                'name' => 'Smart Watch',
                'slug' => 'smart-watch',
                'icon' => 'icons/category/Category-SmartWatch.png',
            ],
        ]);

    }
}
