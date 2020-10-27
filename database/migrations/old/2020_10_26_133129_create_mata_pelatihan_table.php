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
            $table->unsignedBigInteger('program_pelatihan_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('judul');
            $table->text('intro')->nullable();
            $table->text('content')->nullable();
            $table->text('alamat')->nullable();
            $table->boolean('publish');
            $table->timestamp('publish_start')->nullable();
            $table->timestamp('publish_end')->nullable();
            $table->timestamps();

            $table->foreign('program_pelatihan_id')->references('id')
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
