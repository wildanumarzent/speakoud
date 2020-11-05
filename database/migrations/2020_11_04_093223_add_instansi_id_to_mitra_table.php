<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstansiIdToMitraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mitra', function (Blueprint $table) {
            $table->unsignedBigInteger('instansi_id');

            $table->foreign('instansi_id')->references('id')->on('instansi_mitra')
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
        Schema::table('mitra', function (Blueprint $table) {
            $table->dropColumn(['instansi_id']);
        });
    }
}
