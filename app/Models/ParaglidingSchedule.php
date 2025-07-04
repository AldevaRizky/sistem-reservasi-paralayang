<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // 1. IMPORT

class ParaglidingSchedule extends Model
{
    use HasFactory;

    // 2. HAPUS staff_id dari $fillable
    protected $fillable = [
        'paragliding_package_id',
        'schedule_date',
        'time_slot',
        'quota',
        'booked_slots',
        'notes',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(ParaglidingPackage::class, 'paragliding_package_id');
    }

    // 3. UBAH RELASI menjadi belongsToMany
    /**
     * Mendapatkan semua staf/pilot yang ditugaskan pada jadwal ini.
     */
    public function staffs(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'schedule_staff', 'paragliding_schedule_id', 'user_id');
    }
}
