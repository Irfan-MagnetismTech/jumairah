<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqReinforcementSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_reinforcement_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('boq_work_id')->nullable()->constrained('boq_works')->nullOnDelete();

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
            $table->double('formula_percentage')->nullable();
            $table->decimal('quantity',20,2)->nullable();
            $table->double('wastage')->nullable();
            $table->decimal('wastage_quantity',20,2)->nullable();
            $table->decimal('rate',20,2)->default(0);

            $table->integer('dia')->nullable();
            $table->double('calculation_total')->nullable();

            $table->decimal('total_quantity',20,2)->default(0);
            $table->double('total_amount');
            $table->bigInteger('boq_floor_type_id')->nullable();
            $table->bigInteger('boq_work_parent_id')->nullable();

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
        Schema::dropIfExists('boq_reinforcement_sheets');
    }
}
