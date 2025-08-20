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
        Schema::create('benih_pupuk_wilayah_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi', 100)->nullable();
            
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->engine = 'InnoDB';
        });
        
        // Insert default data
        DB::table('benih_pupuk_wilayah_kategori')->insert([
            ['id' => 1, 'deskripsi' => 'Wilayah'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benih_pupuk_wilayah_kategori');
    }
};
