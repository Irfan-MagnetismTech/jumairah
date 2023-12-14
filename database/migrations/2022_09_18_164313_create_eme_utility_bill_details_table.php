<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmeUtilityBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eme_utility_bill_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boq_eme_utility_bills_id');
            $table->foreign('boq_eme_utility_bills_id')->on('boq_eme_utility_bills')->references('id')->onDelete('cascade');
            $table->string('other_cost_name');
            $table->decimal('other_cost_amount',20,5);
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
        Schema::dropIfExists('eme_utility_bill_details');
    }
}
