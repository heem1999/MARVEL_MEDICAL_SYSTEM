<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations_details', function (Blueprint $table) {
            $table->id();
            $table->string('acc', 999)->nullable();
            $table->bigInteger('patient_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('registrations');
            $table->bigInteger('payer_id')->nullable();
            $table->foreign('payer_id')->references('id')->on('payers');
            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('payer_contracts');
            $table->string('insurance_id', 999)->nullable();
            $table->decimal('total_Cash_Required',8,2);
            $table->decimal('total_Credit_Required',8,2);
            $table->decimal('remaining',8,2);
            $table->decimal('paid',8,2)->default(0);
            $table->decimal('discount',8,2)->default(0);
            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('clinic_trans_no')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('user');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->bigInteger('referringDoctors_id')->unsigned()->nullable();
            $table->foreign('referringDoctors_id')->references('id')->on('ReferringDoctors');
            $table->text('time_to_receive_result')->nullable();
            $table->text('regisration_comment')->nullable();
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
        Schema::dropIfExists('registrations_details');
    }
}
