<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // On commence avec la query
        $query = Payroll::query();

        // Appliquer les filtres si définis
        if(!empty($this->filters['year'])){
            $query->where('year', $this->filters['year']);
        }

        if(!empty($this->filters['period'])){
            $query->where('period', $this->filters['period']);
        }

        if(!empty($this->filters['employee_id'])){
            $query->where('employee_id', $this->filters['employee_id']);
        }

        // Sélection des colonnes
        $columns = [
            'employee_id',
            'exchange_rate',
            'period',
            'basic_usd',
            'tax_dependants',
            'worked_days',
            'baremic_salary',
            'sick_days',
            'accommodation_allowance',
            'ot_hours_30',
            'ot_hours_60',
            'ot_hours_100',
            'total_earnings',
            'inss_5',
            'monthly_ipr',
            'ipr_rate',
            'net',
            'net_usd',
            'cnss_13',
            'inpp_2',
            'onem_02',
            'total_taxes_cdf',
            'kitservice_royalties',
            'inss_tax_base',
            'ipr_tax_base',
            'annual_ipr_tax_base',
            'tranche2',
            'tranche3',
            'tranche_gt3',
            'payment_date',
            'status',
            'reference',
            'payment_method',
            'start_date',
            'end_date',
            'year',
            'deleted_at'
        ];

        // Appliquer la sélection et retourner le résultat filtré
        return $query->select($columns)->get();
    }

    // En-têtes de colonnes
    public function headings(): array
    {
        return [
            'Employee ID', 'Exchange Rate', 'Period', 'Basic USD', 'Tax Dependants', 'Worked Days', 'Baremic Salary',
            'Sick Days', 'Accommodation Allowance', 'OT Hours 30%', 'OT Hours 60%', 'OT Hours 100%',
            'Total Earnings', 'INSS 5%', 'Monthly IPR', 'IPR Rate', 'Net', 'Net USD', 'CNSS 13', 'INPP 2', 'ONEM 0.2',
            'Total Taxes CDF', 'KitService Royalties', 'INSS Tax Base', 'IPR Tax Base', 'Annual IPR Tax Base',
            'Tranche 2', 'Tranche 3', 'Tranche >3', 'Payment Date', 'Status', 'Reference', 'Payment Method',
            'Start Date', 'End Date', 'Year', 'Deleted At'
        ];
    }
}
