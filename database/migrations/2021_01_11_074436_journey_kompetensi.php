<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JourneyKompetensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journey_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('kompetensi_id');
            $table->unsignedBigInteger('journey_id');
            $table->bigInteger('minimal_poin')->default(1);
            $table->foreign('journey_id')->references('id')->on('journey')
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
        //
    }
}
