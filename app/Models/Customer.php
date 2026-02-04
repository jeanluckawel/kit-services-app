<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'id_nat', 'rccm', 'nif', 'province', 'ville', 'commune', 'quartier', 'avenue', 'numero', 'telephone', 'email',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
