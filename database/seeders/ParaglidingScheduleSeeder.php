<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParaglidingSchedule;
use App\Models\ParaglidingPackage;
use App\Models\User;

class ParaglidingScheduleSeeder extends Seeder
{
    public function run(): void
    {
        if (ParaglidingPackage::count() === 0) {
            $this->command->warn('Seeder dibatalkan: Tidak ada data ParaglidingPackage.');
            return;
        }

        if (User::where('role', 'staff')->count() === 0) {
            $this->command->warn('Seeder dibatalkan: Tidak ada user dengan role "staff".');
            return;
        }

        $packages = ParaglidingPackage::all();
        $staffs = User::where('role', 'staff')->pluck('id')->toArray();
        $timeOptions = ['08:00:00', '10:30:00', '13:00:00', '15:30:00'];

        $usedTimePerPackage = [];

        foreach (range(1, 20) as $i) {
            $package = $packages->random();
            $packageId = $package->id;

            $availableTimes = array_diff($timeOptions, $usedTimePerPackage[$packageId] ?? []);
            if (empty($availableTimes)) {
                continue;
            }

            $time = collect($availableTimes)->random();
            $usedTimePerPackage[$packageId][] = $time;

            $capacity = (int) $package->capacity_per_slot;
            $quota = rand(1, $capacity);

            $randomStaffs = collect($staffs)->random(rand(1, min(3, count($staffs))))->values()->all();

            ParaglidingSchedule::create([
                'paragliding_package_id' => $packageId,
                'time_slot' => $time,
                'quota' => $quota,
                'notes' => 'Otomatis dari seeder',
                'staff_id' => $randomStaffs,
            ]);
        }

        $this->command->info('Seeder ParaglidingSchedule berhasil dijalankan.');
    }
}
