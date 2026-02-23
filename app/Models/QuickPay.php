<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuickPay extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id', 'exchange_rate', 'year','period', 'day_sick', 'sick', 'day_overtime', 'overtime', 'day_work', 'work', 'deleted_at',
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
