<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateMataBobotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_mata_bobot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_mata_id');
            $table->integer('join_vidconf');
            $table->integer('activity_completion');
            $table->integer('forum_diskusi');
            $table->integer('webinar');
            $table->integer('progress_test')->nullable();
            $table->integer('quiz');
            $table->integer('post_test');
            $table->timestamps();

            $table->foreign('template_mata_id')->references('id')
                ->on('template_mata')
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
        Schema::dropIfExists('template_mata_bobot');
    }
}
