<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultClutuerOrgAntisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_clutuer_org_antis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rct_org_id')->unsigned();
            $table->foreign('rct_org_id')->references('id')->on('result_clutuer_tests');
            $table->bigInteger('antibiotic_id')->unsigned();
            $table->foreign('antibiotic_id')->references('id')->on('antibiotics');
            $table->string('sensitivity', 999)->nullable();
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
        Schema::dropIfExists('result_clutuer_org_antis');
    }
}
