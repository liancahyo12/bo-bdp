<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Karyawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('pelamar_id')->nullable();
            $table->string('kode_karyawan')->nullable();
            $table->string('nama')->nullable();
            $table->date('tem_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->tinyInteger('gender')->nullable()->comment('1= pria, 2=wanita');
            $table->tinyInteger('nikah_status')->nullable()->comment('1= menikah, 2=belum menikah, 3=bercerai');
            $table->integer('jumlah_anak')->nullable();
            $table->string('alamat_ktp')->nullable();
            $table->string('alamat_dom')->nullable();
            $table->string('nik')->nullable();
            $table->string('npwp')->nullable();
            $table->string('email_pel')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('alamat_ortu')->nullable();
            $table->tinyInteger('goldar')->nullable()->comment('1=A, 2=B, 3=O, 4=AB');
            $table->tinyInteger('aktif')->comment('1=aktif, 0=tidak aktif');
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
        Schema::dropIfExists('karyawans');
    }
}
