<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('slug', 50);
            $table->text('intro')->nullable();
            $table->text('content')->nullable();
            $table->json('cover')->nullable();
            $table->boolean('publish')->default(true);
            $table->bigInteger('viewer')->nullable();
            $table->json('meta_data')->nullable()->comment('{
                "title":"", "description":"", "keywords":"",
            }');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('no action');

            $table->foreign('updated_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel');
    }
}
