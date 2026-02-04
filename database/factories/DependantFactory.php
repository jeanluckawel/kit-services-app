<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DependantFactory extends Factory
{
    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'relationship' => $this->faker->randomElement(['Spouse', 'Parent', 'Sibling', 'Other']),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
        ];
    }
}
