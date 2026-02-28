<?php

namespace App\Exports;

use App\Models\Employee\Children;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChildrenExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $children = Children::with('employee')
            ->orderBy('employee_id')
            ->get()
            ->groupBy('employee_id');

        $rows = new Collection();

        foreach ($children as $employeeId => $kids) {

            $first = true;

            foreach ($kids as $child) {

                $employee = $child->employee;

                $fullName = $employee
                    ? $employee->first_name . ' ' .
                    $employee->middle_name . ' ' .
                    $employee->last_name
                    : '';

                $rows->push([
                    'employee_id' => $first ? $employeeId : '',
                    'agent_name'  => $first ? $fullName : '',
                    'child_name'  => $child->full_name,
                    'dob'         => $child->date_of_birth,
                    'gender'      => $child->gender,
                ]);

                $first = false;
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Full Name',
            'Child Name',
            'Date of Birth',
            'Gender'
        ];
    }
}
