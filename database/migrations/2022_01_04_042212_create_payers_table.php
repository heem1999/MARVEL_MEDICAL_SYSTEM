<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payers', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(false);
            $table->string('name_en', 999)->nullable();
            $table->string('name_ar', 999)->nullable();
            $table->bigInteger('code' )->unsigned();
            $table->date('apply_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_insurance_ID_required', 999)->default(false);
            $table->decimal('credit_limit',8,2)->default(0);
            $table->string('phone', 999)->nullable();
            $table->string('email', 999)->nullable();
            $table->bigInteger('currency_id' )->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->boolean('print_money_receipt')->default(false);
            $table->boolean('print_result_receipt')->default(false);
            $table->boolean('print_invoice')->default(false);
            $table->string('web_result_password', 999)->nullable();
            $table->boolean('patient_email_is_required', 999)->default(false);
            $table->boolean('send_result_to_patient', 999)->default(false);
            $table->boolean('send_result_to_payer', 999)->default(false);
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
        Schema::dropIfExists('payers');
    }
}
