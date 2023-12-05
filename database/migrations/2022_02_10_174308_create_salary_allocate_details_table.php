<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAllocateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_allocate_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_allocate_id');
            $table->integer('cost_center_id')->nullable();
            $table->decimal('construction_head_office', 20,2)->nullable();
            $table->decimal('icmd', 20,2)->nullable();
            $table->decimal('architecture', 20,2)->nullable();
            $table->decimal('supply_chain', 20,2)->nullable();
            $table->decimal('construction_project', 20,2)->nullable();
            $table->decimal('contractual_salary', 20,2)->nullable();
            $table->decimal('total_salary', 20,2)->nullable();
            $table->timestamps();
            $table->foreign('salary_allocate_id')->on('salary_allocations')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_allocate_details');
    }
}
