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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('gross_salary')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('house_rent')->default(0);
            $table->string('medical_allowance')->default(0);
            $table->string('tansport_allowance')->default(0);
            $table->string('food_allowance')->default(0);
            $table->string('other_allowance')->default(0);
            $table->string('mobile_allowance')->default(0);
            $table->string('grade_bonus')->default(0);
            $table->string('skill_bonus')->default(0);
            $table->string('management_bonus')->default(0);
            $table->string('total_salary')->default(0);
            $table->string('income_tax')->default(0);
            $table->string('casual_salary')->default(0);
            $table->string('ot_calculation_basis')->nullable()->comment("gross => gross salary, basic => basic salary");
            $table->double('ot_salary')->nullable()->comment("per hour ot salary. unit: percentage");
            $table->uuid('com_id')->nullable();
            $table->timestamps();
            // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_salaries');
    }
};
