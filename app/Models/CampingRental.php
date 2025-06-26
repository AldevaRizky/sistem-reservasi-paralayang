<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampingRental extends Model
{
    protected $fillable = [
        'user_id',
        'rental_start_date',
        'rental_end_date',
        'total_price',
        'rental_status',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

