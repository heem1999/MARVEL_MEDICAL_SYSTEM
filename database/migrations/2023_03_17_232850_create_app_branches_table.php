<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 999);
            $table->string('name_ar', 999);
            $table->bigInteger( 'region_id' )->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->string('phone1', 999)->nullable();
            $table->string('phone2', 999)->nullable();
            $table->string('Address_en', 999)->nullable();
            $table->string('Address_ar', 999)->nullable();
            $table->string('email', 999)->nullable();
            $table->string('lat', 999)->nullable();
            $table->string('lng', 999)->nullable();
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
        Schema::dropIfExists('app_branches');
    }
}
