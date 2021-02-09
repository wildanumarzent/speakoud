<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('lokasi')->nullable();
            $table->json('cover')->nullable();
            $table->boolean('publish')->default(false);
            $table->timestamps();

            $table->foreign('mata_id')->references('id')
                ->on('mata_pelatihan')
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
        Schema::dropIfExists('jadwal_pelatihan');
    }
}
