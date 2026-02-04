<?php

namespace Database\Factories;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    public function definition()
    {
        static $i = 1;
        return [
            'employee_id' => 'Kam' . str_pad($i++, 4, '0', STR_PAD_LEFT),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'middle_name' => $this->faker->firstName,
            'gender' => $this->faker->randomElement(['M','F']),
            'date_of_birth' => $this->faker->date('Y-m-d', '1998-01-01'),
            'place_of_birth' => $this->faker->city,
            'nationality' => 'Congolaise',
            'marital_status' => $this->faker->randomElement(['Single','Married']),
            'number_of_children' => $this->faker->numberBetween(0,3),
            'photo' => null,
            'status' => 1,
        ];
    }
}
