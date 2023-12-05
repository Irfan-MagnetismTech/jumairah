<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeLoadCalculationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_load_calculation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('eme_load_calculation_id');
            $table->foreign('eme_load_calculation_id')->on('boq_eme_load_calculations')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('floor_id')->nullable();
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('load');
            $table->unsignedBigInteger('qty');
            $table->unsignedBigInteger('connected_load');
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
        Schema::dropIfExists('boq_eme_load_calculation_details');
    }
}
