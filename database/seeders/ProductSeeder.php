<?php

namespace Database\Seeders;

use App\Models\image;
use App\Models\products;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \App\Models\products::factory(10)->create();

        foreach ($products as $product) {
            image::factory(1)->create([
                'imageable_id' => $product->id,
                'imageable_type' => products::class
            ]);
        }
    }
}
