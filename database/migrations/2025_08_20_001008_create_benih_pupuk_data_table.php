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
        Schema::create('benih_pupuk_data', function (Blueprint $table) {
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
            
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->engine = 'InnoDB';
        });
        
        // Insert sample data
        DB::table('benih_pupuk_data')->insert([
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 1, 'id_klasifikasi' => 2, 'nilai' => 0, 'status' => null, 'date_created' => '2017-10-29 17:23:32', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 1, 'id_klasifikasi' => 3, 'nilai' => 0, 'status' => null, 'date_created' => '2017-10-29 17:23:32', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 2, 'id_klasifikasi' => 3, 'nilai' => 0, 'status' => null, 'date_created' => '2017-10-29 17:23:35', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 2, 'id_klasifikasi' => 4, 'nilai' => 0, 'status' => null, 'date_created' => '2017-10-29 17:23:35', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 4, 'id_klasifikasi' => 5, 'nilai' => 8141, 'status' => null, 'date_created' => '2017-10-29 17:05:25', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 4, 'id_klasifikasi' => 6, 'nilai' => 8141, 'status' => null, 'date_created' => '2017-10-29 17:05:25', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 5, 'id_klasifikasi' => 5, 'nilai' => 4201.3, 'status' => null, 'date_created' => '2017-10-29 17:05:28', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 5, 'id_klasifikasi' => 6, 'nilai' => 4201.3, 'status' => null, 'date_created' => '2017-10-29 17:05:28', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 6, 'id_klasifikasi' => 5, 'nilai' => 1547, 'status' => null, 'date_created' => '2017-10-29 17:05:31', 'date_modified' => null],
            ['tahun' => 2014, 'id_bulan' => 1, 'id_wilayah' => 1, 'id_variabel' => 6, 'id_klasifikasi' => 6, 'nilai' => 1547, 'status' => null, 'date_created' => '2017-10-29 17:05:31', 'date_modified' => null],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benih_pupuk_data');
    }
};
