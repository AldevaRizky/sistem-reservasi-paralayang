<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParaglidingSchedule;
use App\Models\ParaglidingPackage;

class ParaglidingScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $packages = ParaglidingPackage::all();

        foreach ($packages as $package) {
            ParaglidingSchedule::create([
                'package_id' => $package->id,
                'date' => now()->addDays(rand(1, 10))->toDateString(),
                'start_time' => '07:00:00',
                'end_time' => '08:00:00',
                'available_slots' => rand(1, $package->capacity_per_slot ?? 2),
                'status' => 'available',
                'notes' => 'Jadwal otomatis untuk paket ' . $package->package_name,
            ]);
        }
    }
}
