<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobTitle extends Model
{
    //

    use HasFactory, SoftDeletes;
    protected $fillable = ['name','section_id'];

    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function department() {
        return $this->section->department ?? null;
    }
}
