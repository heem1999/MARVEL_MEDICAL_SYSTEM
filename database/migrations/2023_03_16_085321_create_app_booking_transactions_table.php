<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppBookingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_booking_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('app_bookings');
            $table->bigInteger('edit_by')->default(0);//edit_by by call center user
            $table->foreign('edit_by')->references('id')->on('user');
            $table->bigInteger('patient_info')->default(0);
            $table->bigInteger('patient_services')->default(0);
            $table->string('edit_type', 999)->nullable();
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
        Schema::dropIfExists('app_booking_transactions');
    }
}
