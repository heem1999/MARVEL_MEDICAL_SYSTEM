<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_acc')->nullable();
            $table->bigInteger('appuser_id')->default(0);
            $table->foreign('appuser_id')->references('id')->on('app_users');
            $table->bigInteger('offer_id')->default(0);
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->bigInteger('LabTech_id')->default(0);
            $table->foreign('LabTech_id')->references('id')->on('lab_tech_users');
           // $table->bigInteger('assign_status')->default(0); 
            $table->bigInteger('created_by')->default(0);//created by call center user
            $table->foreign('created_by')->references('id')->on('user');
            //$table->bigInteger('processing_by')->default(0); //call center user
           // $table->foreign('processing_by')->references('id')->on('user');
            $table->bigInteger('canceled_by')->default(0); //call center user or rejected
            $table->foreign('canceled_by')->references('id')->on('user');
            $table->text('canceled_reason')->nullable();// rejected reason
            $table->bigInteger('area_id')->default(0);
            $table->foreign('area_id')->references('id')->on('areas');
            $table->bigInteger('payer_id')->nullable();
            $table->foreign('payer_id')->references('id')->on('payers');
            $table->bigInteger('contract_id')->default(0);
            $table->foreign('contract_id')->references('id')->on('payer_contracts');
            $table->bigInteger('payment_method')->default(0);//cash - 1 online (attach notification)
            $table->bigInteger('payment_status')->default(0);//0 not pay - 1 pay 0 
            $table->bigInteger('status')->default(0);
            $table->string('status_en')->nullable();
            $table->string('status_ar')->nullable();
            $table->float('total')->default(0);
            $table->float('discount')->default(0);
            $table->string('p_name')->nullable();
            $table->string('p_phone1')->nullable();
            $table->string('p_phone2')->nullable();
            $table->string('p_age')->nullable();
            $table->string('p_sex')->nullable();
            $table->string('visit_date')->nullable();
            $table->string('visit_loc_lat')->nullable();
            $table->string('visit_loc_lng')->nullable();
            $table->string('visit_loc_address_en')->nullable();
            $table->string('visit_loc_address_ar')->nullable();
            $table->string('order_destanceKm')->nullable();
            $table->float('ex_km_price_at')->nullable(0);
            $table->float('home_vist_price')->default(0);

            $table->text('note')->nullable();

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
        Schema::dropIfExists('app_bookings');
    }
}
