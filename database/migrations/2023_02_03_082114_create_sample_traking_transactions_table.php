<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleTrakingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_traking_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('sample_status', 999);
            $table->bigInteger('rsb_id')->unsigned();//sample ID
            $table->foreign('rsb_id')->references('id')->on('registration_samples_barcodes');
            $table->bigInteger('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('Processing_units');
            $table->bigInteger('Created_by')->unsigned()->nullable();
            $table->foreign('Created_by')->references('id')->on('user');
            $table->bigInteger('analyzer_id')->unsigned();
            $table->foreign('analyzer_id')->references('id')->on('analyzers');

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
        Schema::dropIfExists('sample_traking_transactions');
    }
}
