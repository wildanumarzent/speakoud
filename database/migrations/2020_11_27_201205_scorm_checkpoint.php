<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScormCheckpoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scorm_checkpoint', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bahan_scorm_id');
            $table->json('checkpoint')->nullable();
            $table->timestamps();
            $table->foreign('bahan_scorm_id')->references('id')->on('bahan_scorm')
            ->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('scorm_checkpoint');
    }
}
