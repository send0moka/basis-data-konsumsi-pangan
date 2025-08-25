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
        Schema::table('benih_pupuk_data', function (Blueprint $table) {
            // First, drop the existing composite primary key
            $table->dropPrimary(['tahun', 'id_bulan', 'id_wilayah', 'id_variabel', 'id_klasifikasi']);
            
            // Add the id column as primary key
            $table->bigIncrements('id')->first();
            
            // Add a unique constraint to prevent duplicates (replaces the old primary key)
            $table->unique(['tahun', 'id_bulan', 'id_wilayah', 'id_variabel', 'id_klasifikasi'], 'unique_data_combination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('benih_pupuk_data', function (Blueprint $table) {
            // Remove the id column
            $table->dropColumn('id');
            
            // Drop the unique constraint
            $table->dropUnique('unique_data_combination');
            
            // Restore the original composite primary key
            $table->primary(['tahun', 'id_bulan', 'id_wilayah', 'id_variabel', 'id_klasifikasi']);
        });
    }
};
