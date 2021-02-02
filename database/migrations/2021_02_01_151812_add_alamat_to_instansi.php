<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlamatToInstansi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instansi_internal', function (Blueprint $table) {
            $table->text('alamat')->nullable();
        });

        Schema::table('instansi_mitra', function (Blueprint $table) {
            $table->text('alamat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instansi_internal', function (Blueprint $table) {
            $table->dropColumn(['alamat']);
        });

        Schema::table('instansi_mitra', function (Blueprint $table) {
            $table->dropColumn(['alamat']);
        });
    }
}
