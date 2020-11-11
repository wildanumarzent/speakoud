<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataInstrukturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_instruktur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_id');
            $table->unsignedBigInteger('instruktur_id');
            $table->timestamps();

            $table->foreign('mata_id')->references('id')
                ->on('mata_pelatihan')
                ->cascadeOnDelete();
            $table->foreign('instruktur_id')->references('id')
                ->on('instruktur')
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
        Schema::dropIfExists('mata_instruktur');
    }
}
