<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReviewRequestSuratKeluar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_request_surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('request_surat_keluar_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->string('komentar')->nullable();
            $table->tinyInteger('request_status')->comment('0 = pending, 1 = dilihat, 2 = proses, 3 = selesai, 4= revisi, 5=ditolak, 6=telah direvisi');
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
        Schema::dropIfExists('review_request_surat_keluars');
    }
}
