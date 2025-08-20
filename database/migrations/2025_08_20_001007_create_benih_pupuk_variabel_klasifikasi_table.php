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
        Schema::create('benih_pupuk_variabel_klasifikasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_variabel');
            $table->unsignedBigInteger('id_klasifikasi');
            $table->string('keterangan', 255)->nullable();
            
            $table->primary(['id_variabel', 'id_klasifikasi']);
            
            $table->foreign('id_variabel')->references('id')->on('benih_pupuk_variabel')
                  ->onDelete('no action')->onUpdate('cascade');
            $table->foreign('id_klasifikasi')->references('id')->on('benih_pupuk_klasifikasi')
                  ->onDelete('no action')->onUpdate('cascade');
            
            $table->index(['id_klasifikasi']);
            
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->engine = 'InnoDB';
        });
        
        // Insert default data
        DB::table('benih_pupuk_variabel_klasifikasi')->insert([
            ['id_variabel' => 1, 'id_klasifikasi' => 2, 'keterangan' => null],
            ['id_variabel' => 1, 'id_klasifikasi' => 3, 'keterangan' => null],
            ['id_variabel' => 2, 'id_klasifikasi' => 3, 'keterangan' => null],
            ['id_variabel' => 2, 'id_klasifikasi' => 4, 'keterangan' => null],
            ['id_variabel' => 3, 'id_klasifikasi' => 1, 'keterangan' => null],
            ['id_variabel' => 4, 'id_klasifikasi' => 5, 'keterangan' => null],
            ['id_variabel' => 4, 'id_klasifikasi' => 6, 'keterangan' => null],
            ['id_variabel' => 5, 'id_klasifikasi' => 5, 'keterangan' => null],
            ['id_variabel' => 5, 'id_klasifikasi' => 6, 'keterangan' => null],
            ['id_variabel' => 6, 'id_klasifikasi' => 5, 'keterangan' => null],
            ['id_variabel' => 6, 'id_klasifikasi' => 6, 'keterangan' => null], // Missing combination added
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benih_pupuk_variabel_klasifikasi');
    }
};
