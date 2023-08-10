<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 999)->nullable();
            $table->string('name_ar', 999)->nullable();
            $table->string('report_name', 999)->nullable();
            $table->string('short_name', 999)->nullable();
            $table->string('service_type', 999)->nullable();
            $table->string('code')->nullable();
            $table->bigInteger('clinical_unit_id')->nullable();
            $table->foreign('clinical_unit_id')->references('id')->on('clinical_units');
            $table->boolean('is_nested_services')->default(false);
            $table->boolean('active')->default(false);
            $table->string('Created_by', 999);
            $table->string('processing_time')->nullable();
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
        Schema::dropIfExists('services');
    }
}
