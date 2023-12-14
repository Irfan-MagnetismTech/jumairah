<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialPlanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_plan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_plan_id');
            $table->foreignId('material_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->integer('week_one')->nullable();
            $table->integer('week_one_rate')->nullable();
            $table->integer('week_two')->nullable();
            $table->integer('week_two_rate')->nullable();
            $table->integer('week_three')->nullable();
            $table->integer('week_three_rate')->nullable();
            $table->integer('week_four')->nullable();
            $table->integer('week_four_rate')->nullable();
            $table->integer('total_quantity')->nullable();
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
        Schema::dropIfExists('material_plan_details');
    }
}
