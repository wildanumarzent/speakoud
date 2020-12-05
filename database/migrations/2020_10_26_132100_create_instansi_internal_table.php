<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstansiInternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instansi_internal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->string('kode_instansi')->nullable();
            $table->string('nip_pimpinan');
            $table->string('nama_pimpinan');
            $table->string('nama_instansi');
            $table->string('jabatan');
            $table->string('telpon')->nullable();
            $table->string('fax')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('instansi_internal');
    }
}
