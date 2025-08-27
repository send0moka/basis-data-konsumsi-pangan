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
        Schema::create('daftar_alamat', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable();
            $table->string('wilayah');
            $table->string('nama_dinas');
            $table->text('alamat');
            $table->string('telp')->nullable();
            $table->string('faks')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('posisi')->nullable();
            $table->integer('urut')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Draft', 'Arsip', 'Pending'])->default('Aktif');
            $table->string('kategori')->nullable();
            $table->text('keterangan')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
            
            $table->index(['wilayah', 'status']);
            $table->index('urut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_alamat');
    }
};
