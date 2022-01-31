<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->smallInteger('jenis_pengajuan_id');
            $table->smallInteger('departemen_id');
            $table->string('no_urut')->nullable();
            $table->string('no_pengajuan')->nullable();
            $table->string('pengajuan')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->string('no_invoice')->nullable();
            $table->string('perusahaan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('phone')->nullable();
            $table->string('kontak')->nullable();
            $table->double('dpp', 20, 2)->nullable();
            $table->double('ppn', 20, 2)->nullable();
            $table->string('email')->nullable();
            $table->string('bank')->nullable();
            $table->string('nama_rek')->nullable();
            $table->string('no_rek')->nullable();
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
            $table->dateTime('bayar_time')->nullable();
            $table->tinyInteger('bayar_status')->nullable()->comment('1 = belum dibayar, 2=telah dibayar');
            $table->string('pengajuan_jadi')->nullable();
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
        Schema::dropIfExists('pengajuans');
    }
}
