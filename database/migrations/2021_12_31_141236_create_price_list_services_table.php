<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceListServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_list_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_id' )->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
            $table->bigInteger('price_list_id' )->unsigned();
            $table->foreign('price_list_id')->references('id')->on('price_lists');
            $table->string('ex_code' )->nullable();
            $table->foreign('ex_code')->references('ex_code')->on('extra_services');
            $table->decimal('current_price',8,2);
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
        Schema::dropIfExists('price_list_services');
    }
}
