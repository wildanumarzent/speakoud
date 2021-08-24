<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAnyfieldPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn('instansi_id');
            $table->dropColumn('nip');
            $table->dropColumn('kedeputian');
            $table->dropColumn('pangkat');
            $table->dropColumn('sk_cpns');
            $table->dropColumn('sk_pengangkatan');
            $table->dropColumn('sk_golongan');
            $table->dropColumn('sk_jabatan');
            $table->dropColumn('surat_ijin_atasan');
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
            $table->unsignedBigInteger('instansi_id')->nullable();
            $table->string('nip')->nullable();
            $table->string('kedeputian')->nullable();
            $table->string('pangkat')->nullable();
            $table->json('sk_cpns')->nullable();
            $table->json('sk_pengangkatan')->nullable();
            $table->json('sk_golongan')->nullable();
            $table->json('sk_jabatan')->nullable();
            $table->json('surat_ijin_atasan')->nullable();
            $table->integer('golongan')->nullable();
            $table->integer('jenjang_jabatan')->nullable();
            $table->boolean('status_profile')->default(0);
            $table->integer('jenis_peserta')->nullable();
        });
    }
}
