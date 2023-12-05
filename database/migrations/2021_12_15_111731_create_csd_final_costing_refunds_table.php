<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsdFinalCostingRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csd_final_costing_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('csd_final_costing_id')->nullable();
            $table->foreignId('material_id_refund')->nullable();
            $table->foreignId('unit_id_refund')->nullable();
            $table->integer('refund_rate')->nullable();
            $table->integer('quantity_refund')->nullable();
            $table->integer('amount_refund')->nullable();
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
        Schema::dropIfExists('csd_final_costing_refunds');
    }
}
