<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetensiMatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetensi_mata', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('kompetensi_id');

            $table->foreign('kompetensi_id')->references('id')->on('kompetensi')
            ->cascadeOnDelete();
            $table->foreign('mata_id')->references('id')->on('mata_pelatihan')
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
        Schema::dropIfExists('kompetensi_mata');
    }
}
