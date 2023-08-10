<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationSamplesBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_samples_barcodes', function (Blueprint $table) {
            $table->id();
            $table->string('acc', 999)->nullable();
            $table->string('sample_barcode', 999)->nullable();
            $table->bigInteger('processing_unit_id')->unsigned();
            $table->foreign('processing_unit_id')->references('id')->on('processing_units');
            $table->string('samples_barcode_status', 999)->nullable();
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
        Schema::dropIfExists('registration_samples_barcodes');
    }
}
