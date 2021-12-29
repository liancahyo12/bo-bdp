<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsiSurat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_surats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('surat_keluar_id')->nullable();
            $table->string('item1')->nullable();
            $table->string('item2')->nullable();
            $table->string('item3')->nullable();
            $table->string('item4')->nullable();
            $table->string('item5')->nullable();
            $table->string('item6')->nullable();
            $table->string('item7')->nullable();
            $table->string('item8')->nullable();
            $table->string('item9')->nullable();
            $table->string('item10')->nullable();
            $table->string('item11')->nullable();
            $table->string('item12')->nullable();
            $table->string('item13')->nullable();
            $table->string('item14')->nullable();
            $table->string('item15')->nullable();
            $table->string('item16')->nullable();
            $table->string('item17')->nullable();
            $table->string('item18')->nullable();
            $table->string('item19')->nullable();
            $table->string('item20')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('isi_surat');
    }
}
