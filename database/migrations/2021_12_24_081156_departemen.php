<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Departemen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('departemens', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('departemen');
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
        //
        Schema::dropIfExists('jenis_surat');
    }
}
