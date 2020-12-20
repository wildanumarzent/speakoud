<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_soal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('creator_id');
            $table->text('pertanyaan');
            $table->tinyInteger('tipe_jawaban')
                ->comment('0 = Multiple Choice, 1 = Exact, 2 = Essay, 3 = True/False');
            $table->json('pilihan')->nullable()->comment('for Multiple Choice');
            $table->json('jawaban')->nullable()
                ->comment('Kosong untuk essay, Array jawaban untuk Exact');
            $table->timestamps();

            $table->foreign('mata_id')->references('id')->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('kategori_id')->references('id')->on('bank_soal_kategori')
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
        Schema::dropIfExists('bank_soal');
    }
}
