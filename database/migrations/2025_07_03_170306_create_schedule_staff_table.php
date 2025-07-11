<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paragliding_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->comment('ID dari staf/pilot')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_staff');
    }
};
