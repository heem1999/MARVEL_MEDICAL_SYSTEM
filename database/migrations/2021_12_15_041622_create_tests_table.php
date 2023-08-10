<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 999);
            $table->string('name_ar', 999)->nullable();
            $table->string('report_name', 999)->nullable();
            $table->bigInteger('code' )->unsigned();
            $table->bigInteger('clinical_unit_id' )->unsigned();
            $table->foreign('clinical_unit_id')->references('id')->on('clinical_units');
            $table->bigInteger('sample_type_id' )->unsigned();
            $table->foreign('sample_type_id')->references('id')->on('sample_types');
            $table->bigInteger('sample_condition_id' )->unsigned();
            $table->foreign('sample_condition_id')->references('id')->on('sample_conditions');
            $table->bigInteger('unit_id' )->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->boolean('active')->default(false);
            $table->string('gender', 999)->nullable();
            $table->string('test_type', 999)->nullable();
            $table->string('Created_by', 999);
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
        Schema::dropIfExists('tests');
    }
}
