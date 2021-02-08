<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKolomToMataPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_pelatihan', function (Blueprint $table) {
            $table->integer('pola_penyelenggaraan')->nullable();
            $table->integer('sumber_anggaran')->nullable();
        });

        Schema::table('template_mata', function (Blueprint $table) {
            $table->integer('pola_penyelenggaraan')->nullable();
            $table->integer('sumber_anggaran')->nullable();
            $table->boolean('soal_acak')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mata_pelatihan', function (Blueprint $table) {
            $table->dropColumn(['sumber_anggaran', 'pola_penyelenggara']);
        });

        Schema::table('template_mata', function (Blueprint $table) {
            $table->dropColumn(['sumber_anggaran', 'pola_penyelenggara']);
        });
    }
}
