<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdProgressYearlyBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_progress_yearly_budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_yearly_budget_id');
            $table->integer('progress_cost_center_id');
            $table->string('progress_particulers')->nullable();
            $table->string('progress_remarks')->nullable();
            $table->bigInteger('progress_amount');
            $table->integer('progress_january')->nullable();
            $table->integer('progress_february')->nullable();
            $table->integer('progress_march')->nullable();
            $table->integer('progress_april')->nullable();
            $table->integer('progress_may')->nullable();
            $table->integer('progress_june')->nullable();
            $table->integer('progress_july')->nullable();
            $table->integer('progress_august')->nullable();
            $table->integer('progress_september')->nullable();
            $table->integer('progress_october')->nullable();
            $table->integer('progress_november')->nullable();
            $table->integer('progress_december')->nullable();
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
        Schema::dropIfExists('bd_progress_yearly_budgets');
    }
}
