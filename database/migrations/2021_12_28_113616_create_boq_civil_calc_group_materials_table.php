<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqCivilCalcGroupMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_civil_calc_group_materials', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('boq_civil_calc_group_id')->nullable()->constrained('boq_civil_calc_groups')->cascadeOnDelete();
            $table->foreignId('material_id')->nullable()->constrained('nested_materials')->cascadeOnDelete();
            $table->decimal('material_price',20,2)->default(0);
            $table->decimal('material_ratio',20,2)->default(0);
            $table->decimal('material_wastage',20,2)->default(0);
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
        Schema::dropIfExists('boq_civil_calc_groups');
    }
}
