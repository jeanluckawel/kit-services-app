<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition()
    {
        return [
            'job_title' => $this->faker->jobTitle,
            'department' => $this->faker->word,
            'section' => $this->faker->word,
            'contract_type' => $this->faker->randomElement(['Permanent', 'Contract']),
            'hire_date' => $this->faker->date('Y-m-d', '2023-01-01'),
            'end_contract_date' => $this->faker->optional()->date('Y-m-d', '2025-12-31'),
            'work_location' => $this->faker->city,
            'supervisor' => $this->faker->name,
            'employee_type' => $this->faker->randomElement(['Full-time', 'Part-time']),
        ];
    }
}
