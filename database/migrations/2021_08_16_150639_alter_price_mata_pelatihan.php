<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPriceMataPelatihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_pelatihan', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->string('fakeRoll')->nullable();
            $table->boolean('is_sertifikat')->nullable();
            $table->boolean('is_penilaian')->nullable();
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
            //
        });
    }
}
