<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParaglidingSchedule extends Model
{
    protected $fillable = [
        'package_id',
        'date',
        'start_time',
        'end_time',
        'available_slots',
        'status',
        'notes',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(ParaglidingPackage::class, 'package_id');
    }
}
