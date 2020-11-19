<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizItemTrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_item_tracker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('quiz_item_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('posisi');
            $table->text('jawaban');
            $table->boolean('benar')->nullable();
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('bahan_quiz')
                ->cascadeOnDelete();
            $table->foreign('quiz_item_id')->references('id')->on('bahan_quiz_item')
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
        Schema::dropIfExists('quiz_item_tracker');
    }
}
