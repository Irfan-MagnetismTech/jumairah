<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanitaryMaterialAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanitary_material_allocations', function (Blueprint $table) {
            $table->id();
            $table->decimal('material_id',10,2)->nullable();
            $table->decimal('project_id',10,2)->nullable();
            $table->decimal('master',10,2)->nullable();
            $table->decimal('master_fc',10,2)->nullable();
            $table->decimal('master_lw',10,2)->nullable();
            $table->decimal('child',10,2)->nullable();
            $table->decimal('child_fc',10,2)->nullable();
            $table->decimal('child_lw',10,2)->nullable();
            $table->decimal('common',10,2)->nullable();
            $table->decimal('common_fc',10,2)->nullable();
            $table->decimal('common_lw',10,2)->nullable();
            $table->decimal('small_toilet',10,2)->nullable();
            $table->decimal('small_toilet_fc',10,2)->nullable();
            $table->decimal('small_toilet_lw',10,2)->nullable();
            $table->decimal('kitchen',10,2)->nullable();
            $table->decimal('kitchen_fc',10,2)->nullable();
            $table->decimal('kitchen_lw',10,2)->nullable();
            $table->decimal('commercial_toilet',10,2)->nullable();
            $table->decimal('basin',10,2)->nullable();
            $table->decimal('urinal',10,2)->nullable();
            $table->decimal('pantry',10,2)->nullable();
            $table->decimal('common_toilet',10,2)->nullable();
            $table->decimal('total',10,2)->nullable();
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
        Schema::dropIfExists('sanitary_material_allocations');
    }
}
