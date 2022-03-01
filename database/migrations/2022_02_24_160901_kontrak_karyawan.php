<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KontrakKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrak_karyawans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->tinyInteger('jenis_kontrak')->nullable()->comment('1=tetap, 2=kontrak, 3=magang, 4=outsource, 5=part time, 6=freelance');
            $table->date('tgl_awal')->nullable();
            $table->date('tgl_akhir')->nullable();
            $table->string('dokumen_kontrak')->nullable();
            $table->tinyInteger('kontrak_status')->comment('1=habis, 2=aktif');
            $table->tinyInteger('status')->default(1)->comment('0 = not valid, 1= valid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kontrak_karyawans');
    }
}
