<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRebatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebates', function (Blueprint $table) {
            $table->id();
            $table->integer('sell_id');
            $table->unsignedBigInteger('sales_collection_detail_id');
            $table->integer('days');
            $table->decimal('amount',18,2);
            $table->timestamps();
            $table->foreign('sales_collection_detail_id')->on('sales_collection_details')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rebates');
    }
}
