<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoalAcakToBahanQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bahan_quiz', function (Blueprint $table) {
            $table->boolean('soal_acak')->default(0);
            $table->integer('jml_soal_acak')->nullable();
        });

        Schema::table('template_bahan_quiz', function (Blueprint $table) {
            $table->boolean('soal_acak')->default(0);
            $table->integer('jml_soal_acak')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bahan_quiz', function (Blueprint $table) {
            $table->dropColumn(['soal_acak', 'jml_soal_acak']);
        });

        Schema::table('template_bahan_quiz', function (Blueprint $table) {
            $table->dropColumn(['soal_acak', 'jml_soal_acak']);
        });
    }
}
