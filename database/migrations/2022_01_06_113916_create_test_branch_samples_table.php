<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestBranchSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_branch_samples', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('test_id' )->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');
            $table->bigInteger('sample_type_id' )->unsigned();
            $table->foreign('sample_type_id')->references('id')->on('sample_types');
            $table->bigInteger('sample_condition_id' )->unsigned();
            $table->foreign('sample_condition_id')->references('id')->on('sample_conditions');
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
        Schema::dropIfExists('test_branch_samples');
    }
}
