<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'reservation_id',
        'rental_id',
        'transaction_type',//'paragliding', 'camping', 'combined'
        'total_payment',
        'payment_method',
        'payment_status', //'pending', 'paid', 'failed', 'refunded'
        'payment_proof',
        'payment_date',
        'verified_by_id',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(ParaglidingReservation::class);
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(CampingRental::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by_id');
    }
}
