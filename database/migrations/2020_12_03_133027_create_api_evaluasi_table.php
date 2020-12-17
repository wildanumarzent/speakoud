<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiEvaluasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('bahan_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->text('token');
            $table->json('evaluasi')->nullable();
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->integer('lama_jawab')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->boolean('is_complete')->default(0);
            $table->timestamps();

            $table->foreign('mata_id')->references('id')->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('bahan_id')->references('id')->on('bahan_pelatihan')
                ->onDelete('set null');
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
        Schema::dropIfExists('api_evaluasi');
    }
}
