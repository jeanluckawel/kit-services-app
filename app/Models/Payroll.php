<?php

namespace App\Models;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    //

    protected $fillable = [
        'employee_id', 'exchange_rate', 'period', 'basic_usd', 'tax_dependants', 'worked_days', 'baremic_salary', 'sick_days', 'accommodation_allowance', 'ot_hours_30', 'ot_hours_60', 'ot_hours_100', 'total_earnings', 'inss_5', 'monthly_ipr', 'ipr_rate', 'net', 'net_usd', 'cnss_13', 'inpp_2', 'onem_02', 'total_taxes_cdf', 'kitservice_royalties', 'inss_tax_base', 'ipr_tax_base', 'annual_ipr_tax_base', 'tranche2', 'tranche3', 'tranche_gt3', 'payment_date', 'status', 'reference', 'payment_method', 'start_date', 'end_date', 'year', 'deleted_at',
    ];

    public function employee()
    {
        return $this->belongsTo(
            \App\Models\Employee\Employee::class,
            'employee_id',
            'employee_id'
        );
    }

}
