<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 999);
            $table->bigInteger( 'region_id' )->unsigned();
            $table->bigInteger( 'code' )->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->string('phone', 999)->nullable();
            $table->string('Address', 999)->nullable();
            $table->string('email', 999)->nullable();
            $table->string('lacation_lat', 999)->nullable();
            $table->string('lacation_lng', 999)->nullable();
            $table->string('Created_by', 999);
            
            $table->boolean('show_result_date_receipt')->default(false);
            $table->boolean('show_time_to_receive_result')->default(false);

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
        Schema::dropIfExists('branches');
    }
}
