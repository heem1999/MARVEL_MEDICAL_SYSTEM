<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayerContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payer_contracts', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(false);
            $table->string('name_en', 999)->nullable();
            $table->string('name_ar', 999)->nullable();
            $table->bigInteger('code')->unsigned();
            $table->bigInteger('payer_id')->nullable();
            $table->foreign('payer_id')->references('id')->on('payers');
            $table->bigInteger('classification_id')->unsigned();
            $table->foreign('classification_id')->references('id')->on('contract_classifications');
            $table->decimal('max_credit_amount_per_visit', 8, 2)->default(0);
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
        Schema::dropIfExists('payer_contracts');
    }
}
