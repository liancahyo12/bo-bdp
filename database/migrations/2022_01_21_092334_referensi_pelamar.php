<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReferensiPelamar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referensi_pelamars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('pelamar_id')->nullable();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('pekerjaan_lokasi')->nullable();
            $table->string('no_hp')->nullable();
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
        Schema::dropIfExists('referensi_pelamars');
    }
}
