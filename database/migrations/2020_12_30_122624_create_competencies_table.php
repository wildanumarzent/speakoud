<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competency', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longtext('deskripsi')->nullable();
            $table->bigInteger('persentase')->default(100);
            $table->string('mata');
            $table->unsignedBigInteger('creator_id');
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
        Schema::dropIfExists('competency');
    }
}
