<?php

namespace Database\Factories;

use App\Models\company;
use App\Models\productype;
use App\Models\supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word(40);
        return [
            'name' => $name,
            'description' => $this->faker->text(60),
            'url' => 'products/' . $this->faker->image('public/storage/products', 640, 480, null, false),
            'users_id' => User::all()->random()->id,
            'productype_id' => productype::all()->random()->id,
            'supplier_id' => supplier::all()->random()->id,
            'company_id' => company::all()->random()->id,
        ];
    }
}
