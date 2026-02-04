<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    //
    use  SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'employee_id', 'job_title', 'department', 'section', 'contract_type', 'hire_date', 'end_contract_date', 'work_location', 'supervisor', 'employee_type',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','employee_id');
    }
}
