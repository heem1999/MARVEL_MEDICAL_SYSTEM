<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultClutuerTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_clutuer_tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rsbst_id')->unsigned();
            $table->foreign('rsbst_id')->references('id')->on('reg_samples_barcode_servs_test');
            $table->bigInteger('organism_id')->unsigned();
            $table->foreign('organism_id')->references('id')->on('organisms');
            $table->string('modifier', 999)->nullable();
            $table->text('test_comment')->nullable();
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
        Schema::dropIfExists('result_clutuer_tests');
    }
}
