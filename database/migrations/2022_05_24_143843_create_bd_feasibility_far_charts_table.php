<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasibilityFarChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasibility_far_charts', function (Blueprint $table) {
            $table->id();
            $table->string('land_category');
            $table->decimal('start_land_sqr_meeter', 20,2);
            $table->decimal('end_land_sqr_meeter', 20,2);
            $table->decimal('start_land_size_katha', 20,2);
            $table->decimal('end_land_size_katha', 20,2);
            $table->decimal('road_meter', 20,2);
            $table->decimal('far', 20,2);
            $table->decimal('max_ground_coverage', 20,2);
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
        Schema::dropIfExists('bd_feasibility_far_charts');
    }
}
