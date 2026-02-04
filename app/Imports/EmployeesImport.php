<?php

namespace App\Imports;

use App\Models\Employee\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
     */
    public function model(array $row)
    {

        $employee = Employee::where('number_card', $row['number_card'] ?? null)->first();

        if (!$employee) {
            $latest = Employee::latest('id')->first();
            $nextId = $latest ? $latest->id + 1 : 1;
            $employeeId = 'KAM_KIT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            $employee = Employee::create([
                'employee_id'    => $employeeId,
                'first_name'     => $row['first_name'] ?? null,
                'last_name'      => $row['last_name'] ?? null,
                'middle_name'    => $row['middle_name'] ?? null,
                'gender'         => $row['gender'] ?? null,
                'date_of_birth'  => $row['date_of_birth'] ?? null,
                'pays'           => $row['pays'] ?? null,
                'marital_status' => $row['marital_status'] ?? null,
                'number_card'    => $row['number_card'] ?? null,
                'status'         => 1,
            ]);
        } else {

            $employee->update([
                'first_name'     => $row['first_name'] ?? $employee->first_name,
                'last_name'      => $row['last_name'] ?? $employee->last_name,
                'middle_name'    => $row['middle_name'] ?? $employee->middle_name,
                'gender'         => $row['gender'] ?? $employee->gender,
                'date_of_birth'  => $row['date_of_birth'] ?? $employee->date_of_birth,
                'pays'           => $row['pays'] ?? $employee->pays,
                'marital_status' => $row['marital_status'] ?? $employee->marital_status,
            ]);
            $employeeId = $employee->employee_id;
        }


        if (!empty($row['city']) || !empty($row['province'])) {
            $employee->address()->updateOrCreate(
                ['employee_id' => $employeeId],
                [
                    'number'          => $row['number'] ?? null,
                    'city'            => $row['city'] ?? null,
                    'province'        => $row['province'] ?? null,
                    'phone'           => $row['phone'] ?? null,
                    'email'           => $row['email'] ?? null,
                    'emergency_phone' => $row['emergency_phone'] ?? null,
                ]
            );
        }


        if (!empty($row['job_title']) || !empty($row['department'])) {
            $employee->company()->updateOrCreate(
                ['employee_id' => $employeeId],
                [
                    'job_title'       => $row['job_title'] ?? null,
                    'department'      => $row['department'] ?? null,
                    'section'         => $row['section'] ?? null,
                    'contract_type'   => $row['contract_type'] ?? null,
                    'hire_date'       => $row['hire_date'] ?? null,
                    'end_contract_date' => $row['end_contract_date'] ?? null,
                    'work_location'   => $row['work_location'] ?? null,
                    'supervisor'      => $row['supervisor'] ?? null,
                    'employee_type'   => $row['employee_type'] ?? null,
                ]
            );
        }


        if (!empty($row['base_salary'])) {
            $employee->salaries()->updateOrCreate(
                ['employee_id' => $employeeId],
                [
                    'base_salary' => $row['base_salary'] ?? null,
                    'category'    => $row['category'] ?? null,
                    'echelon'     => $row['echelon'] ?? null,
                    'currency'    => $row['currency'] ?? null,
                ]
            );
        }

        return $employee;
    }


}
