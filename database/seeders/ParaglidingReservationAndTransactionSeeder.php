<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ParaglidingPackage;
use App\Models\ParaglidingSchedule;
use App\Models\ParaglidingReservation;
use App\Models\Transaction;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class ParaglidingReservationAndTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $users = User::where('role', 'user')->get();

        // Tambahkan user jika kurang
        if ($users->count() < 300) {
            for ($i = 0; $i < 300; $i++) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => bcrypt('password'),
                    'role' => 'user',
                ]);
                $user->detail()->create([
                    'full_name' => $user->name,
                    'is_active' => 'active',
                ]);
            }
            $users = User::where('role', 'user')->get();
        }

        $staffs = User::where('role', 'staff')->pluck('id')->toArray();
        $packages = ParaglidingPackage::where('is_active', 'active')->get();
        $schedules = ParaglidingSchedule::all();

        if ($packages->isEmpty() || $schedules->isEmpty()) {
            $this->command->warn('Seeder dibatalkan: Tidak ada paket atau jadwal yang tersedia.');
            return;
        }

        $today = Carbon::today();
        $startDate = $today->copy()->subYear()->addDay(); // 365 hari ke belakang

        $currentDate = $startDate->copy();

        while ($currentDate->lessThanOrEqualTo($today)) {
            for ($i = 0; $i < 14; $i++) {
                $user = $users->random();
                $package = $packages->random();
                $schedulesForPackage = $schedules->where('paragliding_package_id', $package->id);

                if ($schedulesForPackage->isEmpty()) {
                    continue;
                }

                $schedule = $schedulesForPackage->random();

                $reservationDate = $currentDate->copy()->setTime(rand(6, 16), 0, 0);
                $participants = rand(1, $package->capacity_per_slot);
                $totalPrice = $participants * $package->price;
                $status = $faker->randomElement(['confirmed', 'completed']);

                $reservation = ParaglidingReservation::create([
                    'user_id' => $user->id,
                    'schedule_id' => $schedule->id,
                    'package_id' => $package->id,
                    'reservation_date' => $reservationDate,
                    'participant_count' => $participants,
                    'total_price' => $totalPrice,
                    'reservation_status' => $status,
                    'notes' => 'Reservasi otomatis',
                    'staff_id' => $faker->randomElement($staffs),
                    'customer_name' => $faker->name,
                    'customer_phone' => $faker->phoneNumber,
                    'customer_address' => $faker->address,
                ]);

                Transaction::create([
                    'reservation_id' => $reservation->id,
                    'rental_id' => null,
                    'transaction_type' => 'paragliding',
                    'total_payment' => $totalPrice,
                    'payment_method' => $faker->randomElement(['transfer', 'cash']),
                    'payment_status' => $faker->randomElement(['paid', 'pending']),
                    'payment_proof' => 'proof.jpg',
                    'payment_date' => $reservationDate->copy()->addDays(1),
                    'verified_by_id' => $faker->randomElement($staffs),
                ]);
            }

            $this->command->info("Reservasi tanggal {$currentDate->toDateString()} selesai dibuat.");
            $currentDate->addDay();
        }

        $this->command->info('Seeder selesai: 14 reservasi per hari selama 1 tahun berhasil dimasukkan.');
    }
}
