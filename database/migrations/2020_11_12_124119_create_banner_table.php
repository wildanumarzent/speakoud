<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('banner_kategori_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('file');
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->text('link')->nullable();
            $table->boolean('publish')->default(true);
            $table->integer('urutan');
            $table->timestamps();

            $table->foreign('creator_id')->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreign('banner_kategori_id')->references('id')
                ->on('banner_kategori')
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
        Schema::dropIfExists('banner');
    }
}
