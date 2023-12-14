<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminYearlyBudgetsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_yearly_budget_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id');
            $table->string('month')->nullable();
            $table->string('budget_head_id')->nullable();
            $table->string('remarks')->nullable();
            $table->decimal('amount', 18, 2)->nullable();
            $table->timestamps();
            $table->foreign('budget_id')->on('admin_yearly_budgets')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_yearly_budget_details');
    }
}
