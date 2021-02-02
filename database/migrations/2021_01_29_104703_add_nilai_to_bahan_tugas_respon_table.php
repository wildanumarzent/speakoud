<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNilaiToBahanTugasResponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bahan_tugas_respon', function (Blueprint $table) {
            $table->integer('nilai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bahan_tugas_respon', function (Blueprint $table) {
            $table->dropColumn(['nilai']);
        });
    }
}
