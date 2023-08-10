<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreasuryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treasury_requests', function (Blueprint $table) {
            $table->id();
            $table->boolean('request_status')->default(false);
            $table->bigInteger('treasurie_id')->unsigned();
            $table->foreign('treasurie_id')->references('id')->on('treasuries');
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
        Schema::dropIfExists('treasury_requests');
    }
}
