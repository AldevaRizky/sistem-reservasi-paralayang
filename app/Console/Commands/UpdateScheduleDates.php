<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ParaglidingSchedule;
use Carbon\Carbon;

class UpdateScheduleDates extends Command
{
    protected $signature = 'schedule:update-dates';
    protected $description = 'Update semua tanggal jadwal paralayang menjadi hari ini';

    public function handle()
    {
        $today = Carbon::today();

        $updated = ParaglidingSchedule::query()->update(['date' => $today]);

        $this->info("Berhasil mengupdate {$updated} jadwal ke tanggal: {$today->toDateString()}");
    }
}
