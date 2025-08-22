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
        // Create iklimoptdpi_topik table
        Schema::create('iklimoptdpi_topik', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        // Create iklimoptdpi_variabel table
        Schema::create('iklimoptdpi_variabel', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('satuan');
            $table->timestamps();
        });

        // Create iklimoptdpi_klasifikasi table
        Schema::create('iklimoptdpi_klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        // Create iklimoptdpi_data table
        Schema::create('iklimoptdpi_data', function (Blueprint $table) {
            $table->id();
            $table->decimal('nilai', 15, 2);
            $table->string('wilayah');
            $table->year('tahun');
            $table->string('status');
            $table->foreignId('id_iklimoptdpi_topik')->constrained('iklimoptdpi_topik')->onDelete('cascade');
            $table->foreignId('id_iklimoptdpi_variabel')->constrained('iklimoptdpi_variabel')->onDelete('cascade');
            $table->foreignId('id_iklimoptdpi_klasifikasi')->constrained('iklimoptdpi_klasifikasi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iklimoptdpi_data');
        Schema::dropIfExists('iklimoptdpi_klasifikasi');
        Schema::dropIfExists('iklimoptdpi_variabel');
        Schema::dropIfExists('iklimoptdpi_topik');
    }
};
