<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesKategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades_kategori', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->string('nama');
            $table->text('keterangan')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('grades_kategori');
    }
}
