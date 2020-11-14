<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->integer('parent')->default(0);
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('intro')->nullable();
            $table->text('content')->nullable();
            $table->json('cover')->nullable();
            $table->boolean('publish')->default(true);
            $table->string('custom_view')->nullable();
            $table->bigInteger('viewer')->default(0);
            $table->integer('urutan');
            $table->json('meta_data')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')
                ->on('users')
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
        Schema::dropIfExists('page');
    }
}
