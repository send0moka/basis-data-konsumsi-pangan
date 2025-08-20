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
        
        // Insert default data
        DB::table('benih_pupuk_variabel')->insert([
            ['id' => 1, 'id_topik' => 1, 'deskripsi' => 'Padi Benih Sebar', 'satuan' => 'Ton', 'sorter' => 2],
            ['id' => 2, 'id_topik' => 1, 'deskripsi' => 'Jagung Benih Sebar', 'satuan' => 'Ton', 'sorter' => 3],
            ['id' => 3, 'id_topik' => 1, 'deskripsi' => 'Kedelai Benih Sebar', 'satuan' => 'Ton', 'sorter' => 4],
            ['id' => 4, 'id_topik' => 2, 'deskripsi' => 'Pupuk Urea', 'satuan' => 'Ton', 'sorter' => 5],
            ['id' => 5, 'id_topik' => 2, 'deskripsi' => 'Pupuk SP-36', 'satuan' => 'Ton', 'sorter' => 6],
            ['id' => 6, 'id_topik' => 2, 'deskripsi' => 'Pupuk ZA', 'satuan' => 'Ton', 'sorter' => 7],
            ['id' => 7, 'id_topik' => 2, 'deskripsi' => 'Pupuk NPK', 'satuan' => 'Ton', 'sorter' => 8],
            ['id' => 8, 'id_topik' => 2, 'deskripsi' => 'Pupuk Organik', 'satuan' => 'Ton', 'sorter' => 9],
            ['id' => 9, 'id_topik' => 1, 'deskripsi' => 'Padi Benih Pokok', 'satuan' => 'Ton', 'sorter' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benih_pupuk_variabel');
    }
};
