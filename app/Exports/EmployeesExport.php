<?php

namespace App\Exports;

use App\Models\Employee\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Récupération des employés avec relations
     */
    public function collection()
    {
        $query = Employee::with([
            'address',
            'company',
            'children',
            'dependants',
            'emergencies',
            'salaries',
        ]);

        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }

        if (!empty($this->filters['contract_type'])) {
            $contractType = $this->filters['contract_type'];

            $query->whereHas('company', function ($q) use ($contractType) {
                $q->where('contract_type', $contractType);
            });
        }


        if (isset($this->filters['status']) && $this->filters['status'] !== '') {
            $query->where('status', $this->filters['status']);
        }

        return $query->get();
    }

    /**
     * En-têtes Excel
     */
    public function headings(): array
    {
        return [
            'Employee ID',
            'First Name',
            'Last Name',
            'Middle Name',
            'Gender',
            'Date of Birth',
            'Number Card',
            'Pays',
            'Marital Status',
            'Number',
            'City',
            'Province',
            'Phone',
            'Email',
            'Emergency Phone',
            'Job Title',
            'Department',
            'Section',
            'Contract Type',
            'Hire Date',
            'End Contract Date',
            'Work Location',
            'Supervisor',
            'Employee Type',
            'Base Salary',
            'Category',
            'Echelon',
            'Currency',
            'Status',
        ];
    }

    /**
     * Mapping ligne Excel
     */
    public function map($employee): array
    {
        // 🔐 Sécurisation : on filtre par employee_id
        $address = $employee->address
            ->where('employee_id', $employee->employee_id)
            ->first();

        $company = $employee->company
            ->where('employee_id', $employee->employee_id)
            ->first();

        $salary = $employee->salaries
            ->where('employee_id', $employee->employee_id)
            ->first();

        return [
            $employee->employee_id,
            $employee->first_name,
            $employee->last_name,
            $employee->middle_name,
            $employee->gender,
            $employee->date_of_birth,
            $employee->number_card,
            $employee->pays,
            $employee->marital_status,

            // Address
            $address->number ?? '',
            $address->city ?? '',
            $address->province ?? '',
            $address->phone ?? '',
            $address->email ?? '',
            $address->emergency_phone ?? '',

            // Company
//            $company->job_title ?? '',
            $employee->company?->jobTitleRelation?->name ?? '' ,
            $employee->company?->DepartmentRelation?->name ?? '' ,
//            $company->department ?? '',

            $company->section ?? '',
            $company->contract_type ?? '',
            $company->hire_date ?? '',
            $company->end_contract_date ?? '',
            $company->work_location ?? '',
            $company->supervisor ?? '',
            $company->employee_type ?? '',

            // Salary
            $salary->base_salary ?? '',
            $salary->category ?? '',
            $salary->echelon ?? '',
            $salary->currency ?? '',

            // Status
            $employee->status ?? '',
        ];
    }
}
