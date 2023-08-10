<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisteredServPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registered_serv_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
            $table->string('acc', 999)->nullable();
            $table->decimal('current_price',8,2);
            $table->decimal('service_price_cash',8,2);
            $table->decimal('service_price_credit',8,2);
            $table->boolean('isCanceled')->default(false);
            $table->string('canceled_reasone', 999)->nullable();
            $table->bigInteger('canceled_by')->unsigned()->nullable();
            $table->foreign('canceled_by')->references('id')->on('user');
            $table->string('result_date', 999)->nullable();

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
        Schema::dropIfExists('registered_serv_prices');
    }
}
