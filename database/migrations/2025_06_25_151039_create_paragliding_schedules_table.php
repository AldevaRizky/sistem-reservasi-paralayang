<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paragliding_schedules', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('paragliding_package_id')
                  ->constrained('paragliding_packages')
                  ->onDelete('cascade');
            $table->date('schedule_date');
            $table->time('time_slot'); 
            $table->unsignedInteger('quota');
            $table->unsignedInteger('booked_slots')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paragliding_schedules');
    }
};