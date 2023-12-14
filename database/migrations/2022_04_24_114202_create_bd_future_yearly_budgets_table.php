<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFutureYearlyBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_future_yearly_budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_yearly_budget_id');
            $table->integer('future_cost_center_id');
            $table->string('future_particulers')->nullable();
            $table->string('future_remarks')->nullable();
            $table->bigInteger('future_amount');
            $table->integer('future_january')->nullable();
            $table->integer('future_february')->nullable();
            $table->integer('future_march')->nullable();
            $table->integer('future_april')->nullable();
            $table->integer('future_may')->nullable();
            $table->integer('future_june')->nullable();
            $table->integer('future_july')->nullable();
            $table->integer('future_august')->nullable();
            $table->integer('future_september')->nullable();
            $table->integer('future_october')->nullable();
            $table->integer('future_november')->nullable();
            $table->integer('future_december')->nullable();
            $table->timestamps();
            $table->foreign('bd_yearly_budget_id')->on('bd_yearly_budgets')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_future_yearly_budgets');
    }
}
