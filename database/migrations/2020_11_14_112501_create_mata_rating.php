<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_rating', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('rating');
            $table->timestamps();

            $table->foreign('mata_id')->references('id')
                ->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('user_id')->references('id')
                ->on('users')
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
        Schema::dropIfExists('mata_rating');
    }
}
