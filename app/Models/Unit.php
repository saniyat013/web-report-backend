<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    // use HasFactory
    protected $fillable = [
        'members'
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
