<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqCivilCalcDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_civil_calc_details', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('boq_civil_calc_id')->nullable()->constrained('boq_civil_calcs')->nullOnDelete();
            $table->foreignId('boq_civil_calc_group_id')->nullable()->constrained('boq_civil_calc_groups')->nullOnDelete();
            $table->string('sub_location_name')->nullable();
            $table->foreignId('boq_reinforcement_measurement_id')
                ->nullable()
                ->constrained('boq_reinforcement_measurements')
                ->nullOnDelete();
            $table->decimal('no_or_dia')->unsigned()->nullable();
            $table->string('no_or_dia_fx')->nullable();
            $table->decimal('length')->unsigned()->nullable();
            $table->string('length_fx')->nullable();
            $table->decimal('breadth_or_member')->unsigned()->nullable();
            $table->string('breadth_or_member_fx')->nullable();
            $table->decimal('height_or_bar')->unsigned()->nullable();
            $table->string('height_or_bar_fx')->nullable();
            $table->decimal('total')->unsigned()->nullable();
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
        Schema::dropIfExists('boq_civil_calc_details');
    }
}
