<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsdFinalCostingDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csd_final_costing_demands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('csd_final_costing_id')->nullable();
            $table->foreignId('material_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->integer('demand_rate')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('amount')->nullable();
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
        Schema::dropIfExists('csd_final_costing_demands');
    }
}
