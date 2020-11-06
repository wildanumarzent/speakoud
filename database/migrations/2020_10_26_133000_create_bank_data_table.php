<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id')->comment();
            $table->text('file_path');
            $table->string('file_type')->comment('Mime Type');
            $table->unsignedBigInteger('file_size')->comment('Byte');
            $table->text('thumbnail')->nullable();
            $table->string('filename')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('is_video')->default(0);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')
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
        Schema::dropIfExists('bank_data');
    }
}
