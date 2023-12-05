<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqCivilRevisedSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_civil_revised_sheets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->string('boq_floor_id')->nullable();
            $table->foreign('boq_floor_id')
                ->references('boq_floor_project_id')
                ->on('boq_floor_projects')
                ->nullOnDelete();

            $table->foreignId('nested_material_id')
                ->nullable()
                ->constrained('nested_materials')
                ->nullOnDelete();

            $table->enum('budget_type', ['material', 'labour', 'material-labour', 'other'])
                ->default('material');

            $table->integer('escalation_no')->nullable();
            $table->date('escalation_date')->nullable();

            $table->date('till_date')->nullable();

            $table->string('budget_for')->nullable();
            $table->decimal('primary_qty')->nullable();
            $table->decimal('primary_price')->nullable();
            $table->decimal('primary_amount')->nullable();
            $table->decimal('used_qty')->nullable();
            $table->decimal('current_balance_qty')->nullable();
            $table->decimal('revised_qty')->nullable();
            $table->decimal('revised_price')->nullable();
            $table->decimal('price_after_revised')->nullable();
            $table->decimal('qty_after_revised')->nullable();
            $table->decimal('amount_after_revised')->nullable();
            $table->decimal('increased_or_decreased_amount')->nullable();
            $table->string('remarks')->nullable();

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
        Schema::dropIfExists('boq_civil_revised_sheets');
    }
}
