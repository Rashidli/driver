<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'mark',
        'model',
        'production_year',
        'plate_no',
        'color',
        'mileage'
    ];

    public function drivers()
    {
        return $this->belongsToMany(Driver::class)->withTimestamps()->withTrashed();
    }
}
