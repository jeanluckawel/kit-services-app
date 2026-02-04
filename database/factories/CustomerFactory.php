<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'id_nat' => $this->faker->word(),
            'rccm' => $this->faker->word(),
            'nif' => $this->faker->word(),
            'province' => $this->faker->word(),
            'ville' => $this->faker->word(),
            'commune' => $this->faker->word(),
            'quartier' => $this->faker->word(),
            'avenue' => $this->faker->word(),
            'numero' => $this->faker->word(),
            'telephone' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
