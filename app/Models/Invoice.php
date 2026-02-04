<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id', 'po', 'numero_invoice', 'description', 'unite', 'quantity', 'nb_jours', 'pu', 'pt_jours', 'pt_mois',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


}
