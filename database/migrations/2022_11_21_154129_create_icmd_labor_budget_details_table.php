<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcmdLaborBudgetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icmd_labor_budget_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('icmd_labor_budget_id');
            $table->foreign('icmd_labor_budget_id')->on('icmd_labor_budgets')->references('id')->onDelete('cascade');
            $table->integer('mason_no')->default(0);
            $table->integer('helper_no')->default(0);
            $table->decimal('mason_rate',20,2)->default(0);
            $table->decimal('helper_rate',20,2)->default(0);
            $table->decimal('amount',20,2);
            $table->string('description');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('icmd_labor_budget_details');
    }
}
