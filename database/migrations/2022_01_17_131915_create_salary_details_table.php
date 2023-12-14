<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_id');
            $table->string('unique_key');
            $table->integer('salary_head_id');
            $table->decimal('gross_salary', 20,2)->nullable();
            $table->decimal('fixed_allow', 20,2)->nullable();
            $table->decimal('area_bonus', 20,2)->nullable();
            $table->decimal('other_refund', 20,2)->nullable();
            $table->decimal('less_working_day', 20,2)->nullable();
            $table->decimal('payable', 20,2)->nullable();
            $table->decimal('pf', 20,2)->nullable();
            $table->decimal('other_deduction', 20,2)->nullable();
            $table->decimal('lwd_deduction', 20,2)->nullable();
            $table->decimal('advance_salary', 20,2)->nullable();
            $table->decimal('ait', 20,2)->nullable();
            $table->decimal('mobile_bill', 20,2)->nullable();
            $table->decimal('canteen', 20,2)->nullable();
            $table->decimal('pick_drop', 20,2)->nullable();
            $table->decimal('loan_deduction', 20,2)->nullable();
            $table->decimal('total_deduction', 20,2)->nullable();
            $table->decimal('net_payable', 20,2)->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->foreign('salary_id')->on('salaries')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_details');
    }
}
