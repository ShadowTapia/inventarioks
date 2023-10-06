<?php

namespace Database\Factories;

use App\Models\devices;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'type' => $this->faker->unique()->word(30),
            'devices_id' => devices::all()->random()->id,
        ];
    }
}
