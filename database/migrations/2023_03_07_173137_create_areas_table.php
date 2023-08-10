<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 999)->nullable();
            $table->string('name_ar', 999)->nullable();
            $table->string('zone_lat', 999)->default(0);
            $table->string('zone_lng', 999)->default(0);
            $table->string('zone_radius_km', 999)->default(0);
            $table->float('home_visit_fixed_price')->default(0);
            $table->float('ex_km_price')->default(0);
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
        Schema::dropIfExists('areas');
    }
}
