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
        // For SQLite, we need to recreate the table to add a primary key column
        // This approach works for all database types
        
        // Create temporary table with new structure
        Schema::create('benih_pupuk_data_temp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('tahun');
            $table->tinyInteger('id_bulan', unsigned: true);
            $table->unsignedBigInteger('id_wilayah');
            $table->unsignedBigInteger('id_variabel');
            $table->unsignedBigInteger('id_klasifikasi');
            $table->double('nilai')->nullable();
            $table->string('status', 5)->nullable();
            $table->timestamp('date_created')->useCurrent();
            $table->datetime('date_modified')->nullable();
            
            // Add unique constraint to prevent duplicates (replaces the old primary key)
            $table->unique(['tahun', 'id_bulan', 'id_wilayah', 'id_variabel', 'id_klasifikasi'], 'unique_data_combination');
            
            $table->foreign('id_bulan')->references('id')->on('benih_pupuk_bulan')
                  ->onDelete('no action')->onUpdate('cascade');
            $table->foreign(['id_variabel', 'id_klasifikasi'])->references(['id_variabel', 'id_klasifikasi'])->on('benih_pupuk_variabel_klasifikasi')
                  ->onDelete('no action')->onUpdate('cascade');
            $table->foreign('id_wilayah')->references('id')->on('benih_pupuk_wilayah')
                  ->onDelete('no action')->onUpdate('cascade');
            
            $table->index(['id_bulan']);
            $table->index(['id_variabel', 'id_klasifikasi']);
            $table->index(['id_wilayah']);
        });
        
        // Copy data from old table to new table
        if (Schema::hasTable('benih_pupuk_data')) {
            DB::statement('INSERT INTO benih_pupuk_data_temp (tahun, id_bulan, id_wilayah, id_variabel, id_klasifikasi, nilai, status, date_created, date_modified) 
                          SELECT tahun, id_bulan, id_wilayah, id_variabel, id_klasifikasi, nilai, status, date_created, date_modified 
                          FROM benih_pupuk_data');
        }
        
        // Drop old table
        Schema::dropIfExists('benih_pupuk_data');
        
        // Rename temp table to original name
        Schema::rename('benih_pupuk_data_temp', 'benih_pupuk_data');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the original table structure
        Schema::create('benih_pupuk_data_temp', function (Blueprint $table) {
            $table->smallInteger('tahun');
            $table->tinyInteger('id_bulan', unsigned: true);
            $table->unsignedBigInteger('id_wilayah');
            $table->unsignedBigInteger('id_variabel');
            $table->unsignedBigInteger('id_klasifikasi');
            $table->double('nilai')->nullable();
            $table->string('status', 5)->nullable();
            $table->timestamp('date_created')->useCurrent();
            $table->datetime('date_modified')->nullable();
            
            $table->primary(['tahun', 'id_bulan', 'id_wilayah', 'id_variabel', 'id_klasifikasi']);
            
            $table->foreign('id_bulan')->references('id')->on('benih_pupuk_bulan')
                  ->onDelete('no action')->onUpdate('cascade');
            $table->foreign(['id_variabel', 'id_klasifikasi'])->references(['id_variabel', 'id_klasifikasi'])->on('benih_pupuk_variabel_klasifikasi')
                  ->onDelete('no action')->onUpdate('cascade');
            $table->foreign('id_wilayah')->references('id')->on('benih_pupuk_wilayah')
                  ->onDelete('no action')->onUpdate('cascade');
            
            $table->index(['id_bulan']);
            $table->index(['id_variabel', 'id_klasifikasi']);
            $table->index(['id_wilayah']);
        });
        
        // Copy data back (excluding the id column)
        DB::statement('INSERT INTO benih_pupuk_data_temp (tahun, id_bulan, id_wilayah, id_variabel, id_klasifikasi, nilai, status, date_created, date_modified) 
                      SELECT tahun, id_bulan, id_wilayah, id_variabel, id_klasifikasi, nilai, status, date_created, date_modified 
                      FROM benih_pupuk_data');
        
        // Drop current table and rename temp table
        Schema::dropIfExists('benih_pupuk_data');
        Schema::rename('benih_pupuk_data_temp', 'benih_pupuk_data');
    }
};
