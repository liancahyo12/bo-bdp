<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PendidikanFormal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendidikan_formals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('pelamar_id')->nullable();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->string('sekolah')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('periode')->nullable();
            $table->string('tingkat')->nullable();
            $table->tinyInteger('lulus')->comment('0 = tidak lulus, 1= lulus');
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
        Schema::dropIfExists('pendidikan_formals');
    }
}
