<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestSuratKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('jenis_surat_id');
            $table->unsignedInteger('departemen_id');
            $table->string('perihal');
            $table->string('keterangan');
            $table->string('lampiran')->nullable();
            $table->string('suratkeluars_id')->nullable();
            $table->tinyInteger('send_status')->comment('0 = draft, 1 = terkirim');
            $table->dateTime('send_time')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->tinyInteger('request_status')->nullable()->comment('0 = pending, 1 = dilihat, 2 = proses, 3 = selesai, 4= revisi, 5=ditolak, 6=telah direvisi');
            $table->dateTime('request_time')->nullable();
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
        Schema::dropIfExists('request_surat_keluars');
    }
}
