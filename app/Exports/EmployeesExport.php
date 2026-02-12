<?php

namespace App\Exports;

use App\Models\Employee\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Employee::query();

        // Appliquer les filtres de manière plus robuste
        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }
        if (!empty($this->filters['contract_type'])) {
            $query->where('contract_type', $this->filters['contract_type']);
        }

        return $query->select(['employee_id', 'first_name', 'last_name', 'middle_name', 'gender', 'date_of_birth', 'number_card', 'pays', 'marital_status', 'photo', 'status',
])->get();
    }

    public function headings(): array
    {
        return ['Employee ID', 'First Name', 'Last Name', 'Middle Name', 'Gender', 'Date of birth', 'Number card', 'Pays', 'Marital status', 'number of children', 'photo', 'status',
];
    }
}


