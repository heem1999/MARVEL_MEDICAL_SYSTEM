<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsPriceListSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts_price_list_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('payer_contracts');
            $table->bigInteger('price_list_id' )->unsigned();
            $table->foreign('price_list_id')->references('id')->on('price_lists');
            $table->decimal('cash_ratio',8,2);
            $table->decimal('credit_ratio',8,2);
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
        Schema::dropIfExists('contracts_price_list_settings');
    }
}
