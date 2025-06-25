<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParaglidingPackage extends Model
{
    protected $fillable = [
        'package_name',
        'description',
        'duration',
        'price',
        'requirements',
        'capacity_per_slot',
        'image',
        'is_active',
    ];
}
