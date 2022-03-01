<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SertifikatKypl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat_kypls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('pelamar_id')->nullable();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->string('sertifikat')->nullable();
            $table->string('organisasi')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('tahun')->nullable();
            $table->string('level')->nullable();
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
        Schema::dropIfExists('sertifikat_kypls');
    }
}
