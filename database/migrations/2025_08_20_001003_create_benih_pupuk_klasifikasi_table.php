<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('benih_pupuk_klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi', 255)->nullable();
            
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->engine = 'InnoDB';
        });
        
        // Insert default data
        DB::table('benih_pupuk_klasifikasi')->insert([
            ['id' => 1, 'deskripsi' => '-'],
            ['id' => 2, 'deskripsi' => 'Inbrida'],
            ['id' => 3, 'deskripsi' => 'Hibrida'],
            ['id' => 4, 'deskripsi' => 'Komposit'],
            ['id' => 5, 'deskripsi' => 'Alokasi'],
            ['id' => 6, 'deskripsi' => 'Realisasi'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benih_pupuk_klasifikasi');
    }
};
