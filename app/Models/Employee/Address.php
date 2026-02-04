<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    //
    use SoftDeletes;

    use HasFactory;

    protected $fillable = [
        'employee_id', 'number', 'city', 'province', 'country', 'phone', 'email', 'emergency_phone',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','employee_id');
    }
}
