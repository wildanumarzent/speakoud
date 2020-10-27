<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanQuizItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_quiz_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('materi_id');
            $table->unsignedBigInteger('bahan_id');
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('creator_id');
            $table->text('pertanyaan');
            $table->tinyInteger('tipe_jawaban')
                ->comment('0 = Multiple Choice, 1 = Exact, 2 = Essay');
            $table->text('pilihan')->nullable()->comment('for Multiple Choice');
            $table->text('jawaban')->nullable()
                ->comment('Kosong untuk essay, Array jawaban untuk Exact');
            $table->timestamps();

            $table->foreign('program_id')->references('id')
                ->on('program_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('mata_id')->references('id')
                ->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('materi_id')->references('id')
                ->on('materi_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('bahan_id')->references('id')
                ->on('bahan_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('quiz_id')->references('id')
                ->on('bahan_quiz')
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
        Schema::dropIfExists('bahan_quiz_item');
    }
}
