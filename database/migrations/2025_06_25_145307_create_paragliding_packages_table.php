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
        Schema::create('paragliding_packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name')->nullable();
            $table->text('description')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->text('requirements')->nullable();
            $table->integer('capacity_per_slot')->nullable();
            $table->string('image')->nullable();
            $table->enum('is_active', ['active', 'inactive'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paragliding_packages');
    }
};
