<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanForumTopikDiskusiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_forum_topik_diskusi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('materi_id');
            $table->unsignedBigInteger('bahan_id');
            $table->unsignedBigInteger('forum_id');
            $table->unsignedBigInteger('forum_topik_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('parent')->default(0);
            $table->text('message');
            $table->text('attachment')->nullable();
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
            $table->foreign('forum_topik_id')->references('id')
                ->on('bahan_forum_topik')
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
        Schema::dropIfExists('bahan_forum_topik_diskusi');
    }
}
