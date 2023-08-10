<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsConfigurationsOptionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests_configurations_option_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('test_id' )->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');
            $table->string('option_list_value', 999);
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
        Schema::dropIfExists('tests_configurations_option_lists');
    }
}
