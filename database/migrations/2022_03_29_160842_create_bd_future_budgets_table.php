<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFutureBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_future_budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_budget_id')->nullable();
            $table->integer('future_cost_center_id')->nullable();
            $table->string('future_particulers')->nullable();
            $table->bigInteger('future_amount')->nullable();
            $table->string('future_remarks')->nullable();
            $table->timestamps();
            $table->foreign('bd_budget_id')->on('bd_budgets')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_future_budgets');
    }
}
