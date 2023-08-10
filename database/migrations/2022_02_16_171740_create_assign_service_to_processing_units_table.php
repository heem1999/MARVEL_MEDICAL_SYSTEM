<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignServiceToProcessingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_service_to_processing_unit1s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('proce_unit_id')->unsigned();
            $table->foreign('proce_unit_id')->references('id')->on('processing_units');
            $table->bigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
            $table->bigInteger('reg_branch_id')->unsigned();
            $table->foreign('reg_branch_id')->references('id')->on('branches');
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
        Schema::dropIfExists('assign_service_to_processing_unit1s');
    }
}
