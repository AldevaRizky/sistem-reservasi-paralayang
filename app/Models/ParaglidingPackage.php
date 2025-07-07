<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParaglidingPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_name',
        'description',
        'duration',
        'price',
        'requirements',
        'capacity_per_slot',
        'image',
        'is_active',//'active', 'inactive'
    ];

    public function reservations()
    {
        return $this->hasMany(ParaglidingReservation::class, 'package_id');
    }
}
