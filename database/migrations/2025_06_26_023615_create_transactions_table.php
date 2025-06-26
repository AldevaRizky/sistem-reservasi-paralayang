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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservation_id')
                  ->nullable()
                  ->constrained('paragliding_reservations')
                  ->onDelete('set null');

            $table->foreignId('rental_id')
                  ->nullable()
                  ->constrained('camping_rentals')
                  ->onDelete('set null');

            $table->enum('transaction_type', ['paragliding', 'camping', 'combined'])->nullable();
            $table->decimal('total_payment', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->nullable();
            $table->string('payment_proof')->nullable();
            $table->date('payment_date')->nullable();

            $table->foreignId('verified_by_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
