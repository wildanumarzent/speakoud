<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('peserta_id');
            $table->text('surat_izin')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();

            $table->foreign('mata_id')->references('id')
                ->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('peserta_id')->references('id')->on('peserta')
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
        Schema::dropIfExists('mata_peserta');
    }
}
