<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanPelatihanFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_pelatihan_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_pelatihan_id');
            $table->unsignedBigInteger('mata_pelatihan_id');
            $table->unsignedBigInteger('materi_pelatihan_id');
            $table->unsignedBigInteger('jenis_materi_id');
            $table->unsignedBigInteger('creator_id');
            $table->text('attachment');
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('program_pelatihan_id')->references('id')
                ->on('program_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('mata_pelatihan_id')->references('id')
                ->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('materi_pelatihan_id')->references('id')
                ->on('materi_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('jenis_materi_id')->references('id')
                ->on('jenis_materi')
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
        Schema::dropIfExists('bahan_pelatihan_file');
    }
}
