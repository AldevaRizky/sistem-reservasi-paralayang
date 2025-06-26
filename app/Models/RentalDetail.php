<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalDetail extends Model
{
    protected $fillable = [
        'rental_id',
        'equipment_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(CampingRental::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(CampingEquipment::class);
    }
}

