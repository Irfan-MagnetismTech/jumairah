<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_processed_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('employee_type_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('designation_id');
            $table->string('month');
            $table->string('total_working_day')->nullable();
            $table->string('total_working_amount')->nullable();
            $table->string('total_late_hour')->nullable();
            $table->string('total_late_amount')->nullable();
            $table->string('total_ot_hour')->nullable();
            $table->string('total_late_day')->nullable();
            $table->string('total_ot_amount')->nullable();
            $table->string('adjustment_amount')->nullable();
            $table->string('house_rent')->default(0);
            $table->string('medical_allowance')->default(0);
            $table->string('tansport_allowance')->default(0);
            $table->string('food_allowance')->default(0);
            $table->string('other_allowance')->default(0);
            $table->string('mobile_allowance')->default(0);
            $table->string('grade_bonus')->default(0);
            $table->string('skill_bonus')->default(0);
            $table->string('management_bonus')->default(0);
            $table->string('income_tax')->default(0);
            $table->string('casual_salary')->default(0);
            $table->uuid('com_id')->nullable();
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
        Schema::dropIfExists('temp_processed_salaries');
    }
};
