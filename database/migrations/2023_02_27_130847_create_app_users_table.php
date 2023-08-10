<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_no')->unique();
            $table->string('password');
            $table->string('sex')->nullable();  
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('device_token')->nullable();
            $table->boolean('status')->default(true);
            $table->string('OTP')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('app_lang')->nullable();
            $table->string('fcm_token')->nullable();  
            $table->rememberToken();
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
        Schema::dropIfExists('app_users');
    }
}
