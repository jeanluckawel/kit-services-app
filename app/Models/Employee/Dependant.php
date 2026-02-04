<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dependant extends Model
{
    //
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'employee_id', 'full_name', 'relationship', 'phone', 'address',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','employee_id');
    }


}
