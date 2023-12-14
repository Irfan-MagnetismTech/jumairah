<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqSupremeBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_supreme_budgets', function (Blueprint $table) {
            $table->id();
            $table->string('budget_for');
            $table->integer('project_id');
            $table->enum('budget_type', ['material', 'material-labour', 'other'])->default('material');
            $table->string('floor_id')->nullable();
            $table->integer('material_id');
            $table->decimal('quantity', 20, 2);
            $table->string('remarks', 255)->nullable();
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
        Schema::dropIfExists('boq_supreme_budgets');
    }
}
