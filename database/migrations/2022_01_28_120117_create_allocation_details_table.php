<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('allocation_id');
            $table->integer('cost_center_id')->nullable();
            $table->decimal('management_fee', 20,2)->nullable();
            $table->decimal('division_fee', 20,2)->nullable();
            $table->decimal('construction_depreciation', 20,2)->nullable();
            $table->decimal('architecture_fee', 20,2)->nullable();
            $table->decimal('total_allocation', 20,2)->nullable();
            $table->timestamps();
            $table->foreign('allocation_id')->on('allocations')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allocation_details');
    }
}
