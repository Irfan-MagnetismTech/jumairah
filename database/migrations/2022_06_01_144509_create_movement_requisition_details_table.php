<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementRequisitionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_requisition_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movement_requisition_id');
            $table->integer('material_id');
            $table->integer('quantity');
            $table->foreign('movement_requisition_id')->on('movement_requisitions')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('movement_requisition_details');
    }
}
