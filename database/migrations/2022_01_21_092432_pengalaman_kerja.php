<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengalamanKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('pengalaman_kerjas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('pelamar_id')->nullable();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->string('perusahaan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('bidang')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('fungsi')->nullable();
            $table->string('periode')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('atasan')->nullable();
            $table->string('bawahan')->nullable();
            $table->text('alasan')->nullable();
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
        Schema::dropIfExists('pengalaman_kerjas');
    }
}
