<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersenNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persen_nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->decimal('nilai_minimum');
            $table->decimal('nilai_maksimum');
            $table->char('angka');
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
        Schema::dropIfExists('persen_nilai');
    }
}
