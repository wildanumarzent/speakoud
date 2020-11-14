<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('instansi_id');
            $table->string('nip')->nullable();
            $table->string('kedeputian')->nullable();
            $table->string('pangkat')->nullable();
            $table->text('alamat')->nullable();
            $table->json('sk_cpns')->nullable();
            $table->json('sk_pengangkatan')->nullable();
            $table->json('sk_golongan')->nullable();
            $table->json('sk_jabatan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnDelete();
            $table->foreign('creator_id')->references('id')->on('users')
                ->cascadeOnDelete();
            $table->foreign('instansi_id')->references('id')->on('instansi_internal')
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
        Schema::dropIfExists('internal');
    }
}
