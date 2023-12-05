<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeLoadCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_load_calculations', function (Blueprint $table) {
            $table->id();
            $table->integer('project_type')->default(0)->comment('0=> residential,1=> commercial,2=> residential_cum_commercial');
            $table->integer('calculation_type')->default(0)->comment('0=> common,1=> typical,2=> generator');
            $table->unsignedBigInteger('project_id');
            $table->decimal('total_connecting_wattage',8,2);
            $table->decimal('demand_percent',8,2);
            $table->decimal('total_demand_wattage',8,2);
            $table->decimal('genarator_efficiency',8,2)->nullable();
            $table->unsignedBigInteger('applied_by');
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
        Schema::dropIfExists('boq_eme_load_calculations');
    }
}
