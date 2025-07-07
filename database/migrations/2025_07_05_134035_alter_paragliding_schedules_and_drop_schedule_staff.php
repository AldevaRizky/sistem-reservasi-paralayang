<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: Hapus tabel dan kolom lama, tambahkan JSON staff_id
     */
    public function up(): void
    {
        Schema::dropIfExists('schedule_staff');

        Schema::table('paragliding_schedules', function (Blueprint $table) {
            // Hapus kolom lama jika ada
            if (Schema::hasColumn('paragliding_schedules', 'staff_id')) {
                $table->dropForeign(['staff_id']); // aman meskipun tidak ada
                $table->dropColumn('staff_id');
            }

            if (Schema::hasColumn('paragliding_schedules', 'schedule_date')) {
                $table->dropColumn('schedule_date');
            }
        });

        // Tambahkan kembali kolom staff_id dengan tipe JSON
        Schema::table('paragliding_schedules', function (Blueprint $table) {
            $table->json('staff_id')->nullable()->after('paragliding_package_id');
        });
    }

    /**
     * Rollback perubahan
     */
    public function down(): void
    {
        // Buat ulang tabel schedule_staff jika perlu (struktur minimal contoh)
        Schema::create('schedule_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('paragliding_schedules')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('paragliding_schedules', function (Blueprint $table) {
            $table->dropColumn('staff_id'); // Hapus kolom JSON

            // Tambahkan kembali kolom lama
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->date('schedule_date')->nullable();
        });
    }
};
