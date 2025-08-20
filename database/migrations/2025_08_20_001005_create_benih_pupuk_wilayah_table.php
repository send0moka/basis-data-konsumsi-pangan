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
        
        // Insert sample data (from the original database)
        DB::table('benih_pupuk_wilayah')->insert([
            ['id' => 1, 'kode' => 1, 'nama' => 'Aceh', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 1],
            ['id' => 2, 'kode' => 2, 'nama' => 'Sumatera Utara', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 2],
            ['id' => 3, 'kode' => 3, 'nama' => 'Sumatera Barat', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 3],
            ['id' => 4, 'kode' => 4, 'nama' => 'Riau', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 4],
            ['id' => 5, 'kode' => 5, 'nama' => 'Jambi', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 5],
            ['id' => 6, 'kode' => 6, 'nama' => 'Sumatera Selatan', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 6],
            ['id' => 7, 'kode' => 7, 'nama' => 'Bengkulu', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 7],
            ['id' => 8, 'kode' => 8, 'nama' => 'Lampung', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 8],
            ['id' => 9, 'kode' => 9, 'nama' => 'Bangka Belitung', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 9],
            ['id' => 10, 'kode' => 10, 'nama' => 'Kepulauan Riau', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 10],
        ]);
        
        // Add self-referencing foreign key after data is inserted
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
