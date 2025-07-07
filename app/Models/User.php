<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // 1. TAMBAHKAN BARIS INI
use Illuminate\Database\Eloquent\Relations\HasOne;       // Tambahkan juga ini untuk best practice

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', //admin,staff,user
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Menggunakan 'hashed' adalah praktik modern di Laravel 10+
    ];

    /**
     * Mendapatkan detail yang terhubung dengan user.
     */
    public function detail(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * 2. RELASI INI SUDAH BENAR
     * Mendapatkan semua jadwal yang ditugaskan kepada user (staf) ini.
     */
    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(ParaglidingSchedule::class, 'schedule_staff', 'user_id', 'paragliding_schedule_id');
    }
}
