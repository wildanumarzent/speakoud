<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanForumTopikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_forum_topik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('materi_id');
            $table->unsignedBigInteger('bahan_id');
            $table->unsignedBigInteger('forum_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('subject');
            $table->text('message');
            $table->text('attachment')->nullable();
            $table->boolean('pin')->default(false);
            $table->boolean('lock')->default(false);
            $table->integer('limit_reply')->nullable();
            $table->timestamp('publish_start')->nullable();
            $table->timestamp('publish_end')->nullable();
            $table->timestamps();

            $table->foreign('program_id')->references('id')
                ->on('program_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('mata_id')->references('id')
                ->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('materi_id')->references('id')
                ->on('materi_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('bahan_id')->references('id')
                ->on('bahan_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('forum_id')->references('id')
                ->on('bahan_forum')
                ->cascadeOnDelete();
            $table->foreign('creator_id')->references('id')->on('users')
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
        Schema::dropIfExists('bahan_forum_topik');
    }
}
