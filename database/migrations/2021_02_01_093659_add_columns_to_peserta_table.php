<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('jenis_peserta')->nullable();
            $table->integer('agama')->nullable();
            $table->boolean('jenis_kelamin')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->integer('golongan')->nullable();
            $table->integer('jenjang_jabatan')->nullable();
            $table->boolean('status_profile')->default(0);

            $table->foreign('jabatan_id')->references('id')
                ->on('jabatan')
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
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn(['tempat_lahir', 'tanggal_lahir', 'jenis_peserta',
            'agama', 'jenis_kelamin', 'jabatan_id', 'golongan', 'jenjang_jabatan',
            'status_profile']);
        });
    }
}
