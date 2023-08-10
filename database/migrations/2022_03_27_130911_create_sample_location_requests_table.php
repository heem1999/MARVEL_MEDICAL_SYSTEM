<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleLocationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_location_requests', function (Blueprint $table) {
            $table->id();
            $table->string('previous_status', 999);
            $table->string('current_status', 999);
            $table->boolean('request_status')->default(false);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user');
            $table->bigInteger('processing_units_id')->unsigned();
            $table->foreign('processing_units_id')->references('id')->on('Processing_units');
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
        Schema::dropIfExists('sample_location_requests');
    }
}
