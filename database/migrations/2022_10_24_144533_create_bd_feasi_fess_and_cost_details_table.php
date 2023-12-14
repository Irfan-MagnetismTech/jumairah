<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiFessAndCostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_fess_and_cost_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fess_and_cost_id');
            $table->foreign('fess_and_cost_id')->on('bd_feasi_fess_and_costs')->references('id')->onDelete('cascade');
            $table->integer('headble_id');
            $table->string('headble_type');
            $table->string('calculation');
            $table->double('rate');
            $table->double('quantity');
            $table->string('remarks')->nullable();

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
        Schema::dropIfExists('bd_feasi_fess_and_cost_details');
    }
}
