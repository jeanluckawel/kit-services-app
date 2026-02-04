<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
    public function definition()
    {
        return [
            'base_salary' => $this->faker->numberBetween(1000, 3000),
            'category' => $this->faker->randomElement(['A','B','C']),
            'echelon' => $this->faker->numberBetween(1,5),
            'currency' => $this->faker->randomElement(['USD','CDF']),
        ];
    }
}
