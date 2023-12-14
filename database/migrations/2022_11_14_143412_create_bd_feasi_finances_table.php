<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_finances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->on('bd_lead_generations')->references('id')->onDelete('cascade');
            $table->integer('user_id');
            $table->decimal('rate',20, 2);
            $table->decimal('inflow_amount',20, 2); 
            $table->decimal('outflow_amount',20, 2); 
            $table->decimal('total_interest',20, 2); 
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
        Schema::dropIfExists('bd_feasi_finances');
    }
}
