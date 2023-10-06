<?php

namespace Database\Factories;

use App\Models\department;
use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devices>
 */
class DevicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $numserie = $this->faker->unique()->word(40);
        return [
            'numserie' => $numserie,
            'estado' => $this->faker->randomElement([1, 2]),
            'products_id' => product::all()->random()->id,
            'departments_id' => department::all()->random()->id,
        ];
    }
}
