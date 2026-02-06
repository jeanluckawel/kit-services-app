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

    public function collection()
    {
        $query = Employee::with(['address','company','children','dependants','emergencies','salaries']);


        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }


        if (!empty($this->filters['contract_type'])) {
            $query->whereHas('company', function($q){
                $q->where('contract_type', $this->filters['contract_type']);
            });
        }


        if (request()->has('status') && request('status') !== '') {
            $query->where('status', request('status'));
        }


        return $query->get();
    }

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

            // Address
            'Number',
            'City',
            'Province',
            'Phone',
            'Email',
            'Emergency Phone',

            // Company
            'Job Title',
            'Department',
            'Section',
            'Contract Type',
            'Hire Date',
            'End Contract Date',
            'Work Location',
            'Supervisor',
            'Employee Type',

            // Salaries
            'Base Salary',
            'Category',
            'Echelon',
            'Currency',

//            status
            'status'
        ];
    }

    public function map($employee): array
    {
        $address = $employee->address?->first();
        $company = $employee->company?->first();
        $salary  = $employee->salaries?->first();

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
            $company->job_title ?? '',
            $company->department ?? '',
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

            $employee->status ?? '',
        ];
    }

}


