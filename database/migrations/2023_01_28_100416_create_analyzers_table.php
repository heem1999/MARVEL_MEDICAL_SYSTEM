<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyzersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyzers', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 999);
            $table->bigInteger('branch_id' )->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->bigInteger('processing_units_id')->unsigned();
            $table->foreign('processing_units_id')->references('id')->on('Processing_units');
            $table->boolean('active')->default(false);
            $table->string('comm_port', 999)->nullable();
            $table->string('lms_code', 999)->nullable();
            $table->string('test_status', 999)->nullable();
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
        Schema::dropIfExists('analyzers');
    }
}
