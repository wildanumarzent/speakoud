<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KompetensiPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetensi_peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('kompetensi_id');
            $table->bigInteger('poin')->default(0);
            $table->timestamps();

            $table->foreign('peserta_id')->references('id')->on('peserta')
            ->cascadeOnDelete();
            $table->foreign('kompetensi_id')->references('id')->on('kompetensi')
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
        Schema::dropIfExists('kompetensi_peserta');
    }
}
