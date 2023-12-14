<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanitaryBudgetSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanitary_budget_summaries', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('type')->default(0)->comment('0=>main,1=>incremental');
            $table->decimal('rate_per_unit')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('sanitary_budget_summaries');
    }
}
