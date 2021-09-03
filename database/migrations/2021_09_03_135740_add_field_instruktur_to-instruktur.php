<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldInstrukturToInstruktur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instruktur', function (Blueprint $table) {
            $table->string("nama");
            $table->date('tanggal_lahir')->nullable();
            $table->boolean('gender')->nullable();
            $table->integer('pendidikan')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instruktur', function (Blueprint $table) {
            //
        });
    }
}
