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
        Schema::create('benih_pupuk_variabel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_topik')->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->string('satuan', 100)->nullable();
            $table->integer('sorter')->nullable();
            
            $table->foreign('id_topik')->references('id')->on('benih_pupuk_topik')
                  ->onDelete('no action')->onUpdate('cascade');
            
            $table->index(['id_topik']);
            
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
        Schema::dropIfExists('benih_pupuk_variabel');
    }
};
