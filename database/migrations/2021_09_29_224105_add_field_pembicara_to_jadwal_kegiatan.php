<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPembicaraToJadwalKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->boolean('tipe_agenda')->nullable();
            $table->integer('kuota_peserta')->nullable();
            $table->integer('harga')->nullable();
            $table->string('nama_pembicara')->nullable();
            $table->string('image_pembicara')->nullable();
            $table->string('keterangan_pembicara')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            //
        });
    }
}
