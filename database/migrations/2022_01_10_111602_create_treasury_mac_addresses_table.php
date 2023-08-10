<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreasuryMacAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treasury_mac_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('mac_addres', 999)->nullable();
            $table->bigInteger('treasurie_request_id')->unsigned();
            $table->foreign('treasurie_request_id')->references('id')->on('treasury_requests');
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
        Schema::dropIfExists('treasury_mac_addresses');
    }
}
