<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMonthlyBudgetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_monthly_budget_details', function (Blueprint $table) {
            $table->unsignedBigInteger('budget_id');
            $table->string('badget_head_id');
            $table->decimal('week_one')->nullable();
            $table->decimal('week_two')->nullable();;
            $table->decimal('week_three')->nullable();;
            $table->decimal('week_four')->nullable();;
            $table->decimal('week_five')->nullable();;
            $table->decimal('remarks');
            $table->decimal('amount', 18, 2)->nullable();
            $table->timestamps();
            $table->foreign('budget_id')->on('admin_monthly_budgets')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_monthly_budget_details');
    }
}
