<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisteredServExPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registered_serv_ex_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ex_serv_id')->unsigned();
            $table->foreign('ex_serv_id')->references('id')->on('extra_services');
            $table->string('acc', 999)->nullable();
            $table->decimal('current_price', 8, 2);
            $table->decimal('service_price_cash', 8, 2);
            $table->boolean('isCanceled')->default(false);
            $table->string('canceled_reasone', 999)->nullable();
            $table->bigInteger('done_by')->unsigned()->nullable();
            $table->foreign('done_by')->references('id')->on('non_clinical_users');
            $table->bigInteger('canceled_by')->unsigned()->nullable();
            $table->foreign('canceled_by')->references('id')->on('user');
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
        Schema::dropIfExists('registered_serv_ex_prices');
    }
}
