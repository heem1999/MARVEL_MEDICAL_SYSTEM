<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsConfigurationsNumericsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests_configurations_numerics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('test_id' )->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');

            $table->double('age_Form_d')->value(0);
            $table->double('age_Form_m')->value(0);
            $table->double('age_Form_y')->value(0);

            $table->double('age_To_d')->value(0);
            $table->double('age_To_m')->value(0);
            $table->double('age_To_y')->value(0);

            $table->double('range_From')->value(0);
            $table->double('range_To')->value(0);

            $table->string('gender', 999)->nullable();
            $table->text('reference_range_comment', 999)->nullable();
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
        Schema::dropIfExists('tests_configurations_numerics');
    }
}
