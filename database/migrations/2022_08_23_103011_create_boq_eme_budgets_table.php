<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('budget_head_id');
            $table->foreign('budget_head_id')->references('id')->on('eme_budget_heads')->onDelete('cascade');
            $table->string('specification')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('rate', 20,2);
            $table->decimal('quantity', 20, 2);
            $table->decimal('amount', 20, 2);
            $table->unsignedBigInteger('applied_by');
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
        Schema::dropIfExists('boq_eme_budgets');
    }
}
