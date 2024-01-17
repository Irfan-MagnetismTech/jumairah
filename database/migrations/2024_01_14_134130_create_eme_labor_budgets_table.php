<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmeLaborBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eme_labor_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('boq_eme_rate_id')->constrained()->onDelete('cascade');
            $table->decimal('labor_rate', 20, 2);
            $table->decimal('quantity', 20, 2);
            $table->decimal('total_labor_amount', 20, 2);
            $table->decimal('remarks', 20, 2);
            $table->foreignId('applied_by')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('eme_labor_budgets');
    }
}
