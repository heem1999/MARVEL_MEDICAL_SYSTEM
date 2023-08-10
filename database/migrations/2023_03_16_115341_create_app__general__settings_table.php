<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app__general__settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('booking_is_block')->default(false);
            $table->text('booking_is_block_msg_en')->nullable();
            $table->text('booking_is_block_msg_ar')->nullable();
            $table->boolean('sysytem_is_block')->default(false);
            $table->text('sysytem_is_block_msg_en')->nullable();
            $table->text('sysytem_is_block_msg_ar')->nullable();
            $table->mediumtext('about_en')->nullable();
            $table->mediumtext('about_ar')->nullable();
            $table->text('logo')->nullable();
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
        Schema::dropIfExists('app__general__settings');
    }
}
