<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkPlanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_plan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('workPlan_id');
            $table->string('sub_work', 100)->nullable();
            $table->integer('work_id')->nullable();
            $table->integer('target')->nullable();
            $table->integer('target_accomplishment')->nullable();
            $table->string('description', 255)->nullable();
            $table->integer('material_id')->nullable();
            $table->string('architect_eng_name', 100)->nullable();
            $table->string('sc_eng_name', 100)->nullable();
            $table->year('year');
            $table->integer('month');
            $table->date('start_date');
            $table->date('finish_date');
            $table->string('delay', 255)->nullable();
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
        Schema::dropIfExists('work_plan_details');
    }
}
