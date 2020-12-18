<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanConferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_conference', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('materi_id');
            $table->unsignedBigInteger('bahan_id');
            $table->unsignedBigInteger('creator_id');
            $table->date('tanggal')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->text('meeting_link');
            $table->boolean('tipe')->default(false);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('bahan_conference');
    }
}
