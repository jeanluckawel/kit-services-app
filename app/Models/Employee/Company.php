<?php

namespace App\Models\Employee;

use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Section;
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


    protected $casts = [
        'department' => 'integer',
        'section'    => 'integer',
        'job_title'  => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function departmentRelation()
    {

        return $this->belongsTo(Department::class, 'department', 'id')
            ->withTrashed();
    }

    public function sectionRelation()
    {
        return $this->belongsTo(Section::class, 'section')
            ->withTrashed();
    }

    public function jobTitleRelation()
    {
        return $this->belongsTo(JobTitle::class, 'job_title')
            ->withTrashed();
    }
}
