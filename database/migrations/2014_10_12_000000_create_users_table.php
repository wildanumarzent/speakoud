<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('email_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('active')->default(false)->comment('0 = inactive, 1 = active');
            $table->timestamp('active_at')->nullable();
            $table->json('photo')->nullable()->comment('{
                "file": "name of file", "description": "picture description",
            }');
            $table->text('foto_sertifikat')->nullable();
            $table->bigInteger('userable_id')->nullable();
            $table->string('userable_type')->nullable();
            $table->rememberToken();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('first_access')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_access')->nullable();
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
        Schema::dropIfExists('users');
    }
}
