<?php

namespace App\Models\Employee;

use App\Models\Payroll;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    //
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'employee_id', 'first_name', 'last_name', 'middle_name', 'gender', 'date_of_birth', 'number_card', 'pays', 'marital_status', 'number_of_children', 'photo', 'status',

        'child_full_name',
        'full_name',
    ];
    public function getAgeAttribute(){
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }

    public function address()
    {
        return $this->hasOne(Address::class,'employee_id','employee_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class,'employee_id','employee_id');
    }

    public function children()
    {
        return $this->hasMany(Children::class, 'employee_id','employee_id');
    }

    public function dependants()
    {
        return $this->hasMany(Dependant::class, 'employee_id','employee_id');
    }

    public function emergencies()
    {
        return $this->hasOne(Emergency::class, 'employee_id','employee_id');
    }

    public function salaries()
    {
        return $this->hasOne(Salary::class, 'employee_id','employee_id');
    }

    public function payroll(): HasMany
    {
        return $this->hasMany(Payroll::class, 'employee_id','employee_id');
    }
}
