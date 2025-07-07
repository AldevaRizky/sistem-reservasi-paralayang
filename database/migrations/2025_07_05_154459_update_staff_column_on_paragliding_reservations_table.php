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
        Schema::table('paragliding_reservations', function (Blueprint $table) {
            // Drop foreign key & column
            $table->dropForeign(['tandem_master_id']);
            $table->dropColumn('tandem_master_id');

            // Tambah kolom staff_id sebagai pengganti
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paragliding_reservations', function (Blueprint $table) {
            // Drop new column
            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');

            // Tambahkan kembali tandem_master_id
            $table->foreignId('tandem_master_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
        });
    }
};
