<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'user',
        'expense_type_id',
        'description',
        'amount',
        'currency',
        'file',
        'code'
    ];

    public function type()
    {
        return $this->belongsTo(Expense_Type::class,'expense_type_id');
    }
}
