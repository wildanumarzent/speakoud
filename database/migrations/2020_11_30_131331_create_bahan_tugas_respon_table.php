<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanTugasResponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_tugas_respon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugas_id');
            $table->unsignedBigInteger('user_id');
            $table->text('keterangan')->nullable();
            $table->json('files')->nullable();
            $table->boolean('approval')->nullable();
            $table->timestamp('approval_time')->nullable();
            $table->timestamps();

            $table->foreign('tugas_id')->references('id')->on('bahan_tugas')
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
        Schema::dropIfExists('bahan_tugas_respon');
    }
}
