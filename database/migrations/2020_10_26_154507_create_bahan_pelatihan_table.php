<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('materi_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->boolean('publish')->default(0);
            $table->integer('urutan')->default(0);
            $table->string('ingredientable_type')->nullable();
            $table->unsignedBigInteger('ingredientable_id')->nullable();
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
        Schema::dropIfExists('bahan_pelatihan');
    }
}
