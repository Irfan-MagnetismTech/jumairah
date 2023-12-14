<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceAdjustmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_adjustment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advance_adjustment_id');
            $table->foreign('advance_adjustment_id')->on('advance_adjustments')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('account_id');
            $table->longText('description');
            $table->longText('attachment');
            $table->string('remarks');
            $table->double('amount',20,2);
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
        Schema::dropIfExists('advance_adjustment_details');
    }
}
