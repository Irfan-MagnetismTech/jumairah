<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasibilityEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasibility_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->on('bd_lead_generations')->references('id')->onDelete('cascade');
            $table->integer('user_id');
            $table->decimal('total_payment', 10, 2);
            $table->decimal('rfpl_ratio', 10, 2);
            $table->decimal('registration_cost', 10, 2);
            $table->decimal('adjacent_road_width', 10, 2);
            $table->decimal('parking_area_per_car', 10, 2);
            $table->decimal('building_front_length', 10, 2);
            $table->decimal('floor_number', 10, 2)->nullable();
            $table->decimal('fire_stair_area', 10, 2);
            $table->decimal('parking_number', 10, 2)->nullable();
            $table->decimal('construction_life_cycle', 10, 2);
            $table->decimal('parking_sales_revenue', 10, 2);
            // $table->decimal('semi_basement_floor_area', 10,2);
            // $table->decimal('ground_floor_area', 10,2);
            $table->decimal('apertment_number', 10, 2);
            $table->decimal('floor_area_far_free', 10, 2);
            $table->decimal('bonus_saleable_area', 10, 2);
            $table->decimal('costing_value', 10, 2)->nullable();
            $table->decimal('parking_rate', 10, 2);
            $table->integer('basement_no');
            $table->string('dev_plan');
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
        Schema::dropIfExists('bd_feasibility_entries');
    }
}
