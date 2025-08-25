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
        // Create lahan_topik table
        Schema::create('lahan_topik', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        // Create lahan_variabel table
        Schema::create('lahan_variabel', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('satuan');
            $table->timestamps();
        });

        // Create lahan_klasifikasi table
        Schema::create('lahan_klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        // Create lahan_data table
        Schema::create('lahan_data', function (Blueprint $table) {
            $table->id();
            $table->decimal('nilai', 15, 2);
            $table->string('wilayah');
            $table->year('tahun');
            $table->string('status');
            $table->foreignId('id_lahan_topik')->constrained('lahan_topik')->onDelete('cascade');
            $table->foreignId('id_lahan_variabel')->constrained('lahan_variabel')->onDelete('cascade');
            $table->foreignId('id_lahan_klasifikasi')->constrained('lahan_klasifikasi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahan_data');
        Schema::dropIfExists('lahan_klasifikasi');
        Schema::dropIfExists('lahan_variabel');
        Schema::dropIfExists('lahan_topik');
    }
};
