<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkUserTrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_user_tracker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('join')->nullable();
            $table->timestamp('check_in')->nullable();
            $table->boolean('check_in_verified')->nullable();
            $table->timestamps();

            $table->foreign('link_id')->references('id')->on('bahan_link')
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
        Schema::dropIfExists('link_user_tracker');
    }
}
