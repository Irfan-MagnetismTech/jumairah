<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdProgressBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_progress_budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_budget_id');
            $table->integer('progress_cost_center_id');
            $table->string('progress_particulers')->nullable();
            $table->bigInteger('progress_amount');
            $table->string('progress_remarks')->nullable();
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
        Schema::dropIfExists('bd_progress_budgets');
    }
}
