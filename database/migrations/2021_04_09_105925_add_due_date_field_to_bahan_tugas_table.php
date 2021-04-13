<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDueDateFieldToBahanTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bahan_tugas', function (Blueprint $table) {
            $table->timestamp('tanggal_mulai')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->boolean('after_due_date')->default();
        });

        Schema::table('bahan_tugas_respon', function (Blueprint $table) {
            $table->text('komentar')->nullable();
            $table->boolean('telat')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bahan_tugas', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai', 'after_due_date']);
        });

        Schema::table('bahan_tugas_respon', function (Blueprint $table) {
            $table->dropColumn(['komentar', 'telat']);
        });
    }
}
