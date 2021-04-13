<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTugasMandiriToBobotNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_bobot_nilai', function (Blueprint $table) {
            $table->integer('tugas_mandiri')->nullable();
        });

        Schema::table('template_mata_bobot', function (Blueprint $table) {
            $table->integer('tugas_mandiri')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('template_mata_bobot', function (Blueprint $table) {
            $table->dropColumn(['tugas_mandiri']);
        });

        Schema::table('template_mata_bobot', function (Blueprint $table) {
            $table->dropColumn(['tugas_mandiri']);
        });
    }
}
