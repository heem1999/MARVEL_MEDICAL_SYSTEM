<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleLocationMacAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_location_mac_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('mac', 999);
            $table->bigInteger('sampleLocReq_id')->unsigned();
            $table->foreign('sampleLocReq_id')->references('id')->on('sample_location_requests');
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
        Schema::dropIfExists('sample_location_mac_addresses');
    }
}
