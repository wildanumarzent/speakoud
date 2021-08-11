<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditBankVideoIdToBahanVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bahan_video', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_data_id')->nullable()->change();
        });

        Schema::table('template_bahan_video', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_data_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bahan_video', function (Blueprint $table) {
            $table->dropColumn(['bank_data_id']);
        });

        Schema::table('template_bahan_video', function (Blueprint $table) {
            $table->dropColumn(['bank_data_id']);
        });
    }
}
