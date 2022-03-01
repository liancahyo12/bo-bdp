<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kontak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('kontaks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('pelamar_id')->nullable();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->tinyInteger('jenis_kontak')->nullable()->comment('1=pribadi, 2=orang tua, 3=darurat, 4=pribadi kedua');
            $table->tinyInteger('hubungan')->nullable()->comment('1=ayah, 2=ibu, 3=kakak, 4=adik, 5=teman, 6=suami/istri, 7=pacar');
            $table->string('nama')->nullable();
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
        Schema::dropIfExists('kontaks');
    }
}
