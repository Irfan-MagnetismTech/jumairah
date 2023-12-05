<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialAllocationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_allocation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('financial_allocation_id');
            $table->integer('cost_center_id')->nullable();
            $table->decimal('sod_allocate_amount')->nullable();
            $table->decimal('hbl_allocate_amount')->nullable();
            $table->decimal('total_allocation')->nullable();
            $table->timestamps();
            $table->foreign('financial_allocation_id')->on('financial_allocations')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_allocation_details');
    }
}
