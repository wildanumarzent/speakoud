<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materi_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_pelatihan_id');
            $table->unsignedBigInteger('mata_pelatihan_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('nama');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('program_pelatihan_id')->references('id')
                ->on('program_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('mata_pelatihan_id')->references('id')
                ->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('creator_id')->references('id')->on('users')
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
        Schema::dropIfExists('materi_pelatihan');
    }
}
