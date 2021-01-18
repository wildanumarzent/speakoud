<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJourneyPesertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journey_peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('journey_id');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('complete')->default(0);
            $table->timestamps();
            $table->foreign('journey_id')->references('id')->on('journey')
            ->cascadeOnDelete();
            $table->foreign('peserta_id')->references('id')->on('peserta')
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
        Schema::dropIfExists('journey_peserta');
        $table->unsignedBigInteger('peserta_id');
        $table->unsignedBigInteger('journey_id');
        $table->foreign('peserta_id')->references('id')->on('peserta')
        ->cascadeOnDelete();
        $table->foreign('journey_id')->references('id')->on('journey')
        ->cascadeOnDelete();
    }
}
