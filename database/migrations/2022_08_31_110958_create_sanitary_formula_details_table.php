<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanitaryFormulaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanitary_formula_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sanitary_formula_id');
            $table->integer('material_id')->nullable();
            $table->decimal('multiply_qnt')->nullable();
            $table->decimal('additional_qnt')->nullable();
            $table->string('formula')->nullable();
            $table->timestamps();
            $table->foreign('sanitary_formula_id')->on('sanitary_formulas')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanitary_formula_details');
    }
}
