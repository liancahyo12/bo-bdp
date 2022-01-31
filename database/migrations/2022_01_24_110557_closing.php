<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Closing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('pengajuan_id');
            $table->unsignedBigInteger('user_id');
            $table->smallInteger('jenis_pengajuan_id');
            $table->smallInteger('departemen_id');
            $table->string('no_urut')->nullable();
            $table->string('no_pengajuan')->nullable();
            $table->string('closing')->nullable();
            $table->date('tgl_closing')->nullable();
            $table->string('catatan')->nullable();
            $table->double('total_nominal', 20, 2)->nullable();
            $table->double('jumlah_pc', 20, 2)->nullable();
            $table->string('lampiran')->nullable();
            $table->tinyInteger('send_status')->nullable()->comment('0 = draft, 1 = terkirim');
            $table->dateTime('send_time')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->tinyInteger('review_status')->nullable()->comment('0 = pending, 1 = dilihat, 2 = setuju, 3 = revisi, 4= tolak, 5=telah direvisi');
            $table->dateTime('review_time')->nullable();
            $table->unsignedBigInteger('reviewerdep_id')->nullable();
            $table->tinyInteger('reviewdep_status')->nullable()->comment('0 = pending, 1 = dilihat, 2 = setuju, 3 = revisi, 4= tolak, 5=telah direvisi');
            $table->dateTime('reviewdep_time')->nullable();
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->tinyInteger('approve_status')->nullable()->comment('0 = pending, 1 = dilihat, 2 = setuju, 3 = revisi, 4= tolak, 5=telah direvisi');
            $table->dateTime('approve_time')->nullable();
            $table->tinyInteger('revisi_status')->nullable()->comment('1 = butuh revisi, 2=telah direvisi');
            $table->string('bukti_bayar')->nullable();
            $table->tinyInteger('bayar_status')->nullable()->comment('1 = belum dibayar, 1 = sudah dibayar');
            $table->dateTime('bayar_time')->nullable();
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
        Schema::dropIfExists('closings');
    }
}
