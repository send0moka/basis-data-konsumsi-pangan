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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benih_pupuk_variabel_klasifikasi');
    }
};
