<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesYearlyBudgetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_yearly_budget_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_yearly_budget_id');
            $table->string('month');
            $table->decimal('sales_value', 20,2);
            $table->decimal('booking_money',20,2);
            $table->timestamps();
            $table->foreign('sales_yearly_budget_id')->references('id')->on('sales_yearly_budgets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_yearly_budget_details');
    }
}
