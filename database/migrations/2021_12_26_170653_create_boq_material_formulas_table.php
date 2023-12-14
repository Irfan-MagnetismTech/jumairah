<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqMaterialFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_material_formulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nested_material_id')->nullable()->constrained('nested_materials')->nullOnDelete();
            $table->foreignId('work_id')->nullable()->constrained('boq_works')->nullOnDelete();

            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();

            $table->foreignId('boq_work_id')->nullable()->constrained('boq_works')->nullOnDelete();
            $table->double('percentage_value')->nullable();
            $table->double('wastage')->nullable();
            $table->tinyInteger('is_multiply_calc_no')->nullable()->default(0);
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
        Schema::dropIfExists('boq_material_formulas');
    }
}
