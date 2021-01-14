<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id')->nullable();
            $table->string('nama');
            $table->longText('deskripsi')->nullable();
            $table->longtext('icon');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('tipe_id')->nullable();
            $table->tinyInteger('tipe_utama')->default(1)->comment('0 = activity 1 = completion');
            $table->string('tipe');
            $table->bigInteger('nilai_minimal');
            $table->timestamps();
            $table->foreign('creator_id')->references('id')->on('users')
            ->cascadeOnDelete();
            $table->foreign('mata_id')->references('id')
            ->on('mata_pelatihan')
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
        Schema::dropIfExists('badge');
    }
}
