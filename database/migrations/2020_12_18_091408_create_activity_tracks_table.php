<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('materi_id');
            $table->unsignedBigInteger('peserta_id');
            $table->tinyInteger(1)->default(0);
            $table->timestamps();

            $table->foreign('mata_id')->references('id')
            ->on('mata_pelatihan')
            ->cascadeOnDelete();
            $table->foreign('materi_id')->references('id')
            ->on('materi_pelatihan')
            ->cascadeOnDelete();
            $table->foreign('peserta_id')->references('id')
            ->on('peserta')
            ->cascadeOnDelete();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_aktivitas');
    }
}
