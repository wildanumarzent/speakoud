<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateBahanConference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_bahan_conference', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_mata_id');
            $table->unsignedBigInteger('template_materi_id');
            $table->unsignedBigInteger('template_bahan_id');
            $table->unsignedBigInteger('creator_id');
            $table->boolean('tipe')->default(false);
            $table->timestamps();

            $table->foreign('template_mata_id')->references('id')
                ->on('template_mata')
                ->cascadeOnDelete();

            $table->foreign('template_materi_id')->references('id')
                ->on('template_materi')
                ->cascadeOnDelete();

            $table->foreign('template_bahan_id')->references('id')
                ->on('template_bahan')
                ->cascadeOnDelete();

            $table->foreign('creator_id')->references('id')
                ->on('users')
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
        Schema::dropIfExists('template_bahan_conference');
    }
}
