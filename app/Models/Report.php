<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // use HasFactory;
    protected $fillable = [
        'division_id',
        'district_id',
        'unit_id',
        'total_work',
        'total_id',
        'comment'
    ];
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
