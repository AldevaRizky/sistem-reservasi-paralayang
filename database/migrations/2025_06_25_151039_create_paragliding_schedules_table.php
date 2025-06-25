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
        Schema::create('paragliding_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')
                  ->nullable()
                  ->constrained('paragliding_packages')
                  ->onDelete('set null');
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('available_slots')->nullable();
            $table->enum('status', ['available', 'unavailable', 'full'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paragliding_schedules');
    }
};
