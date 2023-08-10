<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 999);
            $table->bigInteger('sample_type_id' )->unsigned();
            $table->foreign('sample_type_id')->references('id')->on('sample_types')->onDelete('cascade');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('sample_conditions');
    }
}
