<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lisensi_id');;
            $table->text('file_path');
            $table->string('file_type')->comment('Mime Type');
            $table->unsignedBigInteger('file_size')->comment('Byte');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('owner_id')->comment();
            $table->boolean('approved')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('feedback');
            $table->boolean('is_video')->default(false);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('lisensi')
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
        Schema::dropIfExists('private_file');
    }
}
