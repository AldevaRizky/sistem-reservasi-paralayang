<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paragliding_reservations', function (Blueprint $table) {
            $table->id();

            // Kolom yang sudah ada
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->foreignId('schedule_id')
                ->nullable()
                ->constrained('paragliding_schedules')
                ->onDelete('set null');

            $table->foreignId('package_id')
                ->nullable()
                ->constrained('paragliding_packages')
                ->onDelete('set null');

            // --- TAMBAHAN BARU ---
            // Menambahkan kolom untuk menampung ID staf/tandem master
            $table->foreignId('tandem_master_id')
                ->nullable() // Nullable jika staf belum ditugaskan
                ->constrained('users') // Mereferensikan ke tabel 'users'
                ->onDelete('set null'); // Jika staf dihapus, set ID ini menjadi NULL
            // ---------------------

            $table->date('reservation_date')->nullable();
            $table->integer('participant_count')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->enum('reservation_status', ['pending', 'confirmed', 'cancelled', 'completed'])->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paragliding_reservations');
    }
};
