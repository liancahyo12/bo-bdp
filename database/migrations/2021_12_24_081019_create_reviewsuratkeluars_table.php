<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsuratkeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewsuratkeluars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('surat_keluar_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('reviewer_id');
            $table->string('komentar')->nullable();
            $table->tinyInteger('review_status')->comment('0 = pending, 1 = dilihat, 2 = setuju, 3 = revisi, 4= tolak');
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
        Schema::dropIfExists('reviewsuratkeluars');
    }
}
