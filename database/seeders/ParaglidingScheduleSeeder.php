<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParaglidingPackage;
use App\Models\ParaglidingSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ParaglidingScheduleSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ParaglidingSchedule::truncate();
        // Kosongkan juga tabel penghubung
        \DB::table('schedule_staff')->truncate();
        Schema::enableForeignKeyConstraints();

        $packages = ParaglidingPackage::all();
        $staffs = User::where('role', 'staff')->whereHas('detail', function ($query) {
            $query->where('is_active', 'active');
        })->get();

        if ($packages->isEmpty() || $staffs->isEmpty()) {
            $this->command->error('Data Paket atau Staf tidak ditemukan. Seeder jadwal tidak dijalankan.');
            return;
        }

        $timeSlots = ['08:00:00', '10:30:00', '13:00:00', '15:30:00'];
        $this->command->info('Membuat data jadwal paralayang...');

        foreach ($packages as $package) {
            for ($i = -3; $i <= 10; $i++) {
                foreach ($timeSlots as $time) {
                    $date = Carbon::today()->addDays($i);

                    // PENYESUAIAN: Kuota sekarang acak antara 2 dan 4
                    $quota = rand(2, 4);

                    // Pastikan kuota tidak melebihi jumlah staf yang tersedia
                    if ($quota > $staffs->count()) {
                        $quota = $staffs->count();
                    }

                    $bookedSlots = ($i < 0) ? rand(0, $quota) : 0;

                    // 1. Buat jadwalnya terlebih dahulu
                    $schedule = ParaglidingSchedule::create([
                        'paragliding_package_id' => $package->id,
                        'schedule_date' => $date->toDateString(),
                        'time_slot' => $time,
                        'quota' => $quota,
                        'booked_slots' => $bookedSlots,
                        'notes' => 'Catatan seeder otomatis.',
                    ]);

                    // 2. Ambil beberapa staf secara acak sesuai kuota
                    $assignedStaffs = $staffs->random($quota);

                    // 3. Tugaskan staf-staf tersebut ke jadwal yang baru dibuat
                    $schedule->staffs()->attach($assignedStaffs->pluck('id'));
                }
            }
        }

        $this->command->info('Seeder jadwal paralayang berhasil dijalankan.');
    }
}
