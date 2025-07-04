<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk MENGUBAH tabel.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('paragliding_schedules', function (Blueprint $table) {
            $table->foreignId('staff_id')
                ->nullable() 
                ->after('paragliding_package_id') 
                ->constrained('users') 
                ->onDelete('set null');
        });
    }

    
    public function down(): void
    {
        Schema::table('paragliding_schedules', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);

            $table->dropColumn('staff_id');
        });
    }
};
