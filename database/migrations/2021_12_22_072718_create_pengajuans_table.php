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
            $table->string('jenis_pengajuan');
            $table->string('judul');
            $table->string('deskripsi');
            $table->double('nominal', 20, 2);
            $table->string('lampiran');
            $table->tinyInteger('send_status')->comment('0 = draft, 1 = terkirim');
            $table->dateTime('send_time')->nullable();
            $table->unsignedBigInteger('reviewer_id');
            $table->tinyInteger('review_status')->comment('0 = pending, 1 = dilihat, 2 = setuju, 3 = revisi, 4= tolak');
            $table->dateTime('review_time')->nullable();
            $table->unsignedBigInteger('approver_id');
            $table->tinyInteger('approve_status')->comment('0 = pending, 1 = dilihat, 2 = setuju, 3 = revisi, 4= tolak');
            $table->dateTime('approve_time')->nullable();
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
