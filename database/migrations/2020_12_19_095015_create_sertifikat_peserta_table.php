<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat_peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sertifikat_id');
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('peserta_id');
            $table->text('file_path');
            $table->timestamps();

            $table->foreign('sertifikat_id')->references('id')
                ->on('sertifikat_internal')
                ->cascadeOnDelete();
            $table->foreign('mata_id')->references('id')
                ->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('peserta_id')->references('id')
                ->on('peserta')
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
        Schema::dropIfExists('sertifikat_peserta');
    }
}
