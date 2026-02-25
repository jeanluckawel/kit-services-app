<?php

namespace App\Exports;

use App\Models\Employee\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmployeesExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnFormatting
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Récupération des employés avec filtres
     */
    public function collection()
    {
        $query = Employee::with([
            'address',
            'company.jobTitleRelation',
            'company.DepartmentRelation',
            'children',
            'dependants',
            'emergencies',
            'salaries',
        ]);

        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }

        if (!empty($this->filters['contract_type'])) {
            $query->whereHas('company', function ($q) {
                $q->where('contract_type', request('contract_type'));
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
     * Mapping Excel (FORCÉ TEXTE)
     */
    public function map($employee): array
    {
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
            // 🔒 IDs aussi protégés
            "'" . $employee->employee_id,
            $employee->first_name,
            $employee->last_name,
            $employee->middle_name,
            $employee->gender,
            $employee->date_of_birth,
            "'" . ($employee->number_card ?? ''),
            $employee->pays,
            $employee->marital_status,

            // Address
            "'" . ($address->number ?? ''),
            $address->city ?? '',
            $address->province ?? '',
            "'" . ($address->phone ?? ''),
            $address->email ?? '',
            "'" . ($address->emergency_phone ?? ''),

            // Company
            $employee->company?->jobTitleRelation?->name ?? '',
            $employee->company?->DepartmentRelation?->name ?? '',
            $employee->company?->sectionRelation?->name ?? '',
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

    /**
     * 🔐 Forcer les colonnes en TEXTE (double sécurité)
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
            'O' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
