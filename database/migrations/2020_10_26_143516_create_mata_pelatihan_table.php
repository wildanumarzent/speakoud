<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('judul');
            $table->text('intro')->nullable();
            $table->text('content')->nullable();
            $table->json('cover')->nullable();
            $table->boolean('publish')->default(0);
            $table->timestamp('publish_start')->nullable();
            $table->timestamp('publish_end')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('program_id')->references('id')
                ->on('program_pelatihan')
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
        Schema::dropIfExists('mata_pelatihan');
    }
}
