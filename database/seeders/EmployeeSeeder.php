<?php

namespace Database\Seeders;

use App\Models\Employee\Address;
use App\Models\Employee\Children;
use App\Models\Employee\Company;
use App\Models\Employee\Dependant;
use App\Models\Employee\Emergency;
use App\Models\Employee\Employee;
use App\Models\Employee\Salary;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        Employee::factory()
            ->count(60)
            ->has(Address::factory())
            ->has(Company::factory())
            ->has(Children::factory()->count(2))
            ->has(Dependant::factory()->count(2))
            ->has(Emergency::factory()->count(2))
            ->has(Salary::factory())
            ->create();
    }
}
