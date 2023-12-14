<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_budgets', function (Blueprint $table) {
            $table->id();
            $table->date('applied_date');
            $table->year('year');
            $table->integer('month');
            $table->bigInteger('progress_total_amount')->nullable();
            $table->bigInteger('future_total_amount')->nullable();
            $table->bigInteger('total_amount');
            $table->integer('entry_by');
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
        Schema::dropIfExists('bd_budgets');
    }
}
