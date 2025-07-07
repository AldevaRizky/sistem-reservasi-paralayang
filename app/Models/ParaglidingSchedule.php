<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\ParaglidingPackage;

class ParaglidingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'paragliding_package_id',
        'time_slot',
        'quota',
        'staff_id', // stored as JSON array
        'notes',
    ];

    protected $casts = [
        'staff_id' => 'array', // Cast JSON to array automatically
    ];

    /**
     * Relasi ke paket paralayang
     */
    public function package()
    {
        return $this->belongsTo(ParaglidingPackage::class, 'paragliding_package_id');
    }

    /**
     * Ambil daftar user staff berdasarkan ID dalam kolom JSON staff_id
     */
    public function staffs()
    {
        return User::whereIn('id', $this->staff_id ?? [])->get();
    }
}
