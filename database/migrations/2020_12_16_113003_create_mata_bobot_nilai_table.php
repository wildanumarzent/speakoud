<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataBobotNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_bobot_nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id');
            $table->integer('join_vidconf');
            $table->integer('activity_completion');
            $table->integer('forum_diskusi');
            $table->integer('webinar');
            $table->integer('progress_test')->nullable();
            $table->integer('quiz');
            $table->integer('post_test');
            $table->timestamps();

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
        Schema::dropIfExists('mata_bobot_nilai');
    }
}
