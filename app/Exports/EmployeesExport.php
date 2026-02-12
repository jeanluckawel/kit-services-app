<?php

namespace App\Exports;

use App\Models\Employee\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class EmployeesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Employee::with(['company', 'children', 'dependants', 'emergencies', 'salaries', 'address']);

        // Appliquer les filtres de manière plus robuste
        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }
        if (!empty($this->filters['contract_type'])) {
            $contract = $this->filters['contract_type'];
            $query->whereHas('company', function ($q) use ($contract) {
                $q->where('contract_type', $contract);
            });
        }

        $employees = $query->get();

        $rows = $employees->map(function (Employee $e) {
            $children = $e->children->map(function ($c) {
                return trim(sprintf('%s (%s)', $c->full_name ?? '', $c->date_of_birth ?? ''));
            })->filter()->join('; ');

            $dependants = $e->dependants->map(function ($d) {
                return trim(sprintf('%s|%s|%s|%s', $d->full_name ?? '', $d->relationship ?? '', $d->phone ?? '', $d->address ?? ''));
            })->filter()->join('; ');

            $emergency = $e->emergencies ? trim(sprintf('%s|%s|%s|%s', $e->emergencies->full_name ?? '', $e->emergencies->relationship ?? '', $e->emergencies->phone ?? '', $e->emergencies->address ?? '')) : '';

            $company = $e->company;
            $salary = $e->salaries;
            $address = $e->address;

            return [
                'employee_id' => $e->employee_id,
                'first_name' => $e->first_name,
                'last_name' => $e->last_name,
                'middle_name' => $e->middle_name,
                'gender' => $e->gender,
                'date_of_birth' => $e->date_of_birth,
                'number_card' => $e->number_card,
                'pays' => $e->pays,
                'marital_status' => $e->marital_status,
                'number_of_children' => $e->number_of_children,
                'photo' => $e->photo,
                'status' => $e->status,
                'job_title' => $company->job_title ?? null,
                'department' => $company->department ?? null,
                'section' => $company->section ?? null,
                'contract_type' => $company->contract_type ?? null,
                'hire_date' => $company->hire_date ?? null,
                'end_contract_date' => $company->end_contract_date ?? null,
                'work_location' => $company->work_location ?? null,
                'supervisor' => $company->supervisor ?? null,
                'employee_type' => $company->employee_type ?? null,
                'children' => $children,
                'dependants' => $dependants,
                'emergency_contact' => $emergency,
                'base_salary' => $salary->base_salary ?? null,
                'category' => $salary->category ?? null,
                'echelon' => $salary->echelon ?? null,
                'currency' => $salary->currency ?? null,
                'address' => $address ? sprintf('%s, %s, %s, %s', $address->number ?? '', $address->city ?? '', $address->province ?? '', $address->country ?? '') : null,
                'address_phone' => $address->phone ?? null,
                'address_email' => $address->email ?? null,
            ];
        });

        return $rows->values();
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
}
