<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParaglidingReservation extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'package_id',
        'reservation_date',
        'participant_count',
        'total_price',
        'reservation_status', //'pending', 'confirmed', 'cancelled', 'completed'
        'notes',
        'staff_id',
        'customer_name',
        'customer_phone',
        'customer_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(ParaglidingSchedule::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(ParaglidingPackage::class);
    }

    /**
     * The staff assigned to this reservation.
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id')->where('role', 'staff');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'reservation_id');
    }

}
