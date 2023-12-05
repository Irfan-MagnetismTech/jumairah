<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_in_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movement_in_id');
            $table->integer('movement_requisition_id');
            $table->integer('material_id');
            $table->integer('mti_quantity');
            $table->integer('damage_quantity')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps(); 
            $table->foreign('movement_in_id')->references('id')->on('movement_ins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movement_in_details');
    }
}
