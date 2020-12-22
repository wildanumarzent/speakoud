<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgeCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge_criteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badge_id');
            $table->tinyInteger('criteria')->comment('1=manual,2=course,3=profile,4=award,5=activity');
            $table->longText('criteria_required');
            $table->tinyInteger('all_required')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badge_criteria');
    }
}
