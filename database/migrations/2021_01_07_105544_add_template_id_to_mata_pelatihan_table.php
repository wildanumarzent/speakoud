<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateIdToMataPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_pelatihan', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable();

            $table->foreign('template_id')->references('id')->on('template_mata')
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
        Schema::table('mata_pelatihan', function (Blueprint $table) {
            $table->dropColumn(['template_id']);
        });
    }
}
