<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->bigInteger('how_expire')->default(0);
            $table->string('expiry_date')->nullable();
            $table->bigInteger('max_usage')->nullable();
            $table->bigInteger('max_use_user')->nullable();
            $table->bigInteger('min_amount')->nullable();
            $table->bigInteger('discount_type')->nullable();
            $table->float('discount')->unsigned();	
            $table->bigInteger('status')->default(0);
            $table->string('icon')->nullable();
            $table->string('Created_by', 999);
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
        Schema::dropIfExists('offers');
    }
}
