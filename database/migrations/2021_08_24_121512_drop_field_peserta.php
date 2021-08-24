<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFieldPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn('jenis_peserta');
            $table->dropColumn('golongan');
            $table->dropColumn('jenjang_jabatan');
            $table->dropColumn('status_profile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->integer('golongan')->nullable();
            $table->integer('jenjang_jabatan')->nullable();
            $table->boolean('status_profile')->default(0);
            $table->integer('jenis_peserta')->nullable();
        });
    }
}
