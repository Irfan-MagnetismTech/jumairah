<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockoutdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockoutdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stockout_id');
            $table->integer('raw_material_id');
            $table->float('quantity');
            $table->date('return_date')->nullable();
            $table->string('product_remarks')->nullable();
            $table->timestamps();

            $table->foreign('stockout_id')->on('stockouts')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stockoutdetails');
    }
}
