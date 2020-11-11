<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('mitra_id')->nullable();
            $table->string('nip')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('kedeputian')->nullable();
            $table->string('pangkat')->nullable();
            $table->text('alamat')->nullable();
            $table->json('sk_cpns')->nullable();
            $table->json('sk_pengangkatan')->nullable();
            $table->json('sk_golongan')->nullable();
            $table->json('sk_jabatan')->nullable();
            $table->json('surat_ijin_atasan')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnDelete();
            $table->foreign('creator_id')->references('id')->on('users')
                ->cascadeOnDelete();
            $table->foreign('mitra_id')->references('id')->on('mitra')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peserta');
    }
}
