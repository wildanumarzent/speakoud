<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstansiIdToInternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal', function (Blueprint $table) {
            $table->unsignedBigInteger('instansi_id');

            $table->foreign('instansi_id')->references('id')->on('instansi_internal')
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
        Schema::table('internal', function (Blueprint $table) {
            $table->dropColumn(['instansi_id']);
        });
    }
}
