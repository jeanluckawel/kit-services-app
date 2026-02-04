<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChildrenFactory extends Factory
{
    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'date_of_birth' => $this->faker->date,
            'gender' => $this->faker->randomElement(['M','F']),
            'school' => $this->faker->randomElement(['School A', 'School B', 'School C', 'School D']),
        ];
    }
}
