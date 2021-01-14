<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateBahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_bahan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_mata_id');
            $table->unsignedBigInteger('template_materi_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->tinyInteger('completion_type')->default(0);
            $table->json('completion_parameter')->nullable();
            $table->boolean('restrict_access')->nullable();
            $table->unsignedBigInteger('requirement')->nullable();
            $table->string('segmenable_type')->nullable();
            $table->unsignedBigInteger('segmenable_id')->nullable();
            $table->timestamps();

            $table->foreign('template_mata_id')->references('id')
                ->on('template_mata')
                ->cascadeOnDelete();

            $table->foreign('template_materi_id')->references('id')
                ->on('template_materi')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('template_bahan');
    }
}
