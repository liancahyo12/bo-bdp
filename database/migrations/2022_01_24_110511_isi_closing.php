<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsiClosing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_closings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('closing_id')->nullable();
            $table->unsignedBigInteger('pengajuan_id')->nullable();
            $table->smallInteger('jenis_pengajuan_id')->nullable();
            $table->integer('no')->nullable();
            $table->string('transaksi')->nullable();
            $table->double('nominal', 20, 2)->nullable();
            $table->string('jumlah_barang')->nullable();
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
        Schema::dropIfExists('isi_closings');
    }
}
