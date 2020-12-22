<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->json('image')->nullable()->comment('{
                "image":"", "caption":"", "author_url":"","author_name":"","author_email":"",
            }');
            $table->json('issuer')->nullable()->comment('{
                "name":"", "contact":"",
            }');
            $table->tinyInteger('status')->default(0)->comment('1 = publish , 0 = unpublish');
            $table->tinyInteger('type')->default(0)->comment('0 = site , 1 = course');
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('badges');
    }
}
