<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockreturndetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockreturndetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stockreturn_id');
            $table->integer('stockoutdetail_id');
            $table->integer('raw_material_id')->nullable();
            $table->float('quantity')->nullable();
            $table->string('product_remarks')->nullable();
            $table->timestamps();
            $table->foreign('stockreturn_id')->on('stockreturns')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stockreturndetails');
    }
}
