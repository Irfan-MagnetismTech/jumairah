<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionYearlyBudgetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_yearly_budget_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yearly_budget_id');
            $table->string('month');
            $table->decimal('collection_amount',20,2);
            $table->timestamps();
            $table->foreign('yearly_budget_id')->references('id')->on('collection_yearly_budgets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_yearly_budget_details');
    }
}
