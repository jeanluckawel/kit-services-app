<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perception extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name', 'amount', 'file', 'currency', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
