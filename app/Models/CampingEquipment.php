<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampingEquipment extends Model
{
    protected $table = 'camping_equipment';

    protected $fillable = [
        'equipment_name',
        'category',
        'description',
        'daily_rental_price',
        'total_quantity',
        'available_quantity',
        'image',
        'equipment_status',
    ];
}
