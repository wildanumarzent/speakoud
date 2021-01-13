<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_soal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_mata_id');
            $table->unsignedBigInteger('template_kategori_id');
            $table->unsignedBigInteger('creator_id');
            $table->text('pertanyaan');
            $table->tinyInteger('tipe_jawaban')
                ->comment('0 = Multiple Choice, 1 = Exact, 2 = Essay, 3 = True/False');
            $table->json('pilihan')->nullable()->comment('for Multiple Choice');
            $table->json('jawaban')->nullable()
                ->comment('Kosong untuk essay, Array jawaban untuk Exact');
            $table->timestamps();

            $table->foreign('template_mata_id')->references('id')->on('template_mata')
                ->cascadeOnDelete();
            $table->foreign('template_kategori_id')->references('id')->on('template_soal_kategori')
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
        Schema::dropIfExists('template_soal');
    }
}
