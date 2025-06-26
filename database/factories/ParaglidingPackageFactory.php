<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ParaglidingPackageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'package_name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'duration' => $this->faker->randomElement(['30 menit', '1 jam', '2 jam']),
            'price' => $this->faker->numberBetween(150000, 500000),
            'requirements' => $this->faker->sentence,
            'capacity_per_slot' => $this->faker->numberBetween(1, 10),
            'image' => null, // Optional, bisa juga dummy link
            'is_active' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
