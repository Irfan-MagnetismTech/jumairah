<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTentativeBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tentative_budgets', function (Blueprint $table) {
            $table->id();
            $table->integer('cost_center_id');
            $table->year('applied_year');
            $table->integer('tentative_month');
            $table->integer('material_cost');
            $table->integer('labor_cost');
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
        Schema::dropIfExists('tentative_budgets');
    }
}
