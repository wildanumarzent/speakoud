<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->json('general')->nullable()->comment('{
                "city":"-", "description":"-"
            }');
            $table->json('additional_name')->nullable()->comment('{
                "first_name":"-", "sur_name":"-", "middle_name":"-",
                "alternate_name":""
            }');
            $table->json('optional')->nullable()->comment('{
                "web_page":"-", "icq_number":"-", "skype_id":"-", "aim_id":"-",
                "yahoo_id":"-", "msn_id":"-", "id_number":"-", "instution":"-",
                "departement":"-", "phone":"-", "mobile_phone":"-", "address":"-",
            }');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('users_information');
    }
}
