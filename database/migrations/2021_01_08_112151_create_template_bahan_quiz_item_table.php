<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateBahanQuizItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_bahan_quiz_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_mata_id');
            $table->unsignedBigInteger('template_materi_id');
            $table->unsignedBigInteger('template_bahan_id');
            $table->unsignedBigInteger('template_quiz_id');
            $table->unsignedBigInteger('creator_id');
            $table->text('pertanyaan');
            $table->tinyInteger('tipe_jawaban')
                ->comment('0 = Multiple Choice, 1 = Exact, 2 = Essay');
            $table->text('pilihan')->nullable()->comment('for Multiple Choice');
            $table->text('jawaban')->nullable()
                ->comment('Kosong untuk essay, Array jawaban untuk Exact');
            $table->timestamps();

            $table->foreign('template_mata_id')->references('id')
                ->on('template_mata')
                ->cascadeOnDelete();
            $table->foreign('template_materi_id')->references('id')
                ->on('template_materi')
                ->cascadeOnDelete();
            $table->foreign('template_bahan_id')->references('id')
                ->on('template_bahan')
                ->cascadeOnDelete();
            $table->foreign('template_quiz_id')->references('id')
                ->on('template_bahan_quiz')
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
        Schema::dropIfExists('template_bahan_quiz_item');
    }
}
