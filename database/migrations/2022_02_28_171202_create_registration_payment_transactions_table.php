<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('acc', 999)->nullable();
            $table->string('transaction_type', 999)->nullable();
            $table->string('payment_method', 999)->nullable();
            $table->decimal('amount',8,2);
            $table->bigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->bigInteger('Created_by')->unsigned()->nullable();
            $table->foreign('Created_by')->references('id')->on('user');
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
        Schema::dropIfExists('registration_payment_transactions');
    }
}
