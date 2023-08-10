<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegSamplesBarcodeServsTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_samples_barcode_servs_tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rsbs_id')->unsigned();
            $table->foreign('rsbs_id')->references('id')->on('registration_samples_barcode_services');
            $table->bigInteger('test_id')->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');
            $table->string('result', 999)->nullable();
            $table->string('unit', 999)->nullable();
            $table->string('from', 999)->nullable();
            $table->string('to', 999)->nullable();
            $table->string('non_num_ref', 999)->nullable();
            $table->bigInteger('analyzer_id')->unsigned();
            $table->foreign('analyzer_id')->references('id')->on('Analyzers');
            $table->string('test_status', 999)->nullable();
            $table->text('test_comment')->nullable();
            $table->string('test_comment_type')->default('Result');
            $table->bigInteger('saved_by')->unsigned()->nullable();
            $table->foreign('saved_by')->references('id')->on('user');
            $table->bigInteger('verify_by')->unsigned()->nullable();
            $table->foreign('verify_by')->references('id')->on('user');
            $table->bigInteger('reviewed_by')->unsigned()->nullable();
            $table->foreign('reviewed_by')->references('id')->on('user');
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
        Schema::dropIfExists('reg_samples_barcode_servs_tests');
    }
}
