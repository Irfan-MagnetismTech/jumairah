<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateBoqWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_works', function (Blueprint $table)
        {
            $table->id();
            NestedSet::columns($table);
            $table->string('name');
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('material_unit')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('labour_unit')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('material_labour_unit')->nullable()->constrained('units')->nullOnDelete();
            $table->tinyInteger('is_reinforcement')->default(0);
            $table->tinyInteger('is_multiply_calc_no')->default(0);
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
        Schema::dropIfExists('boq_works');
    }
}
