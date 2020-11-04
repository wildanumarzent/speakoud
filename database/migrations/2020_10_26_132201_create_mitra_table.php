<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('nip')->nullable();
            $table->string('kedeputian')->nullable();
            $table->string('pangkat')->nullable();
            $table->text('alamat')->nullable();
            $table->text('sk_cpns')->nullable();
            $table->text('sk_pengangkatan')->nullable();
            $table->text('sk_golongan')->nullable();
            $table->text('sk_jabatan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('mitra');
    }
}
