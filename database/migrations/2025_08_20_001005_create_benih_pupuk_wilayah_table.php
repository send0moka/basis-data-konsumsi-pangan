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
        Schema::create('benih_pupuk_wilayah', function (Blueprint $table) {
            $table->id();
            $table->integer('kode');
            $table->string('nama', 255)->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->unsignedBigInteger('id_parent')->nullable();
            $table->integer('sorter')->nullable();
            
            $table->index(['id_kategori']);
            $table->index(['id_parent']);
            
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->engine = 'InnoDB';
        });
        
        // Add foreign key constraints after table creation
        Schema::table('benih_pupuk_wilayah', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id')->on('benih_pupuk_wilayah_kategori')
                  ->onDelete('no action')->onUpdate('cascade');
        });
        
        // Add self-referencing foreign key
        Schema::table('benih_pupuk_wilayah', function (Blueprint $table) {
            $table->foreign('id_parent')->references('id')->on('benih_pupuk_wilayah')
                  ->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benih_pupuk_wilayah');
    }
};
