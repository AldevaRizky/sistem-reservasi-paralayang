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
        Schema::create('camping_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->decimal('daily_rental_price', 10, 2)->nullable();
            $table->integer('total_quantity')->nullable();
            $table->integer('available_quantity')->nullable();
            $table->string('image')->nullable();
            $table->enum('equipment_status', ['available', 'unavailable', 'damaged', 'maintenance'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camping_equipment');
    }
};
