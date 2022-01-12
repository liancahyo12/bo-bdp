<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratkeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratkeluars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('request_surat_keluar_id')->nullable();
            $table->string('no_urut')->nullable();
            $table->unsignedInteger('jenis_surat_id');
            $table->unsignedInteger('departemen_id');
            $table->date('tgl_surat');
            $table->string('no_surat')->nullable();
            $table->string('perihal');
            $table->string('isi_surat')->nullable();
            $table->string('lampiran')->nullable();
            $table->tinyInteger('send_status')->comment('0 = draft, 1 = terkirim');
            $table->dateTime('send_time')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->tinyInteger('review_status')->nullable()->comment('0 = pending, 1 = dilihat, 2 = setuju, 3 = revisi, 4= tolak, 5=telah direvisi');
            $table->dateTime('review_time')->nullable();
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->tinyInteger('approve_status')->nullable()->comment('0 = pending, 1 = dilihat, 2 = setuju, 3 = revisi, 4= tolak, 5=telah direvisi');
            $table->dateTime('approve_time')->nullable();
            $table->string('surat_jadi')->nullable();
            $table->string('surat_scan')->nullable();
            $table->dateTime('scan_time')->nullable();
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
        Schema::dropIfExists('suratkeluars');
    }
}
