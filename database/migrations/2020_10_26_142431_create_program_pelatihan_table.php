<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('mitra_id')->nullable();
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('urutan')->default(0);
            $table->boolean('tipe')->default(false)->comment('0 = internal, 1 = mitra');
            $table->timestamps();
            
            $table->foreign('creator_id')->references('id')->on('users')
                ->cascadeOnDelete();
            $table->foreign('mitra_id')->references('id')->on('mitra')
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
        Schema::dropIfExists('program_pelatihan');
    }
}
