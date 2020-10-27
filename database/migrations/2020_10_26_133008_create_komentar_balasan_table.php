<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarBalasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentar_balasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('komentar_id');
            $table->unsignedBigInteger('user_id');
            $table->text('komentar');
            $table->timestamps();

            $table->foreign('komentar_id')->references('id')->on('komentar')
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
        Schema::dropIfExists('komentar_balasan');
    }
}
