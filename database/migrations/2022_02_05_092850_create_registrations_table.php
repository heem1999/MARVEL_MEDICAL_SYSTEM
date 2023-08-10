<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name', 999)->nullable();
            $table->string('patient_no', 999)->nullable();
            $table->string('gender', 999)->nullable();
            $table->string('marital_status', 999)->nullable();
            $table->string('DOB', 999)->nullable();
            $table->string('age_y', 999)->nullable();
            $table->string('age_m', 999)->nullable();
            $table->string('age_d', 999)->nullable();
            $table->string('phone', 999)->nullable();
            $table->string('email', 999)->nullable();
            $table->string('passport', 999)->nullable();
            $table->string('reg_date', 999)->nullable();
            $table->bigInteger('Created_by')->unsigned()->nullable();
            $table->foreign('Created_by')->references('id')->on('user');
            $table->bigInteger('Edited_by')->unsigned()->nullable();
            $table->foreign('Edited_by')->references('id')->on('user');
            $table->bigInteger('status')->default(1);
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
        Schema::dropIfExists('registrations');
    }
}
