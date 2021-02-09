<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeToSertifikatInternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sertifikat_internal', function (Blueprint $table) {
            $table->integer('tipe')->default(0);
            $table->text('unit_kerja')->nullable();
            $table->text('pejabat_terkait')->nullable();
            $table->string('nama_pejabat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sertifikat_internal', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'unit_kerja', 'pejabat_terkait', 'nama_pejabat']);
        });
    }
}
