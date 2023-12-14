<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiRncCalCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_rnc_cal_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bd_feasi_rnc_cal_id')->references('id')->on('bd_feasi_rnc_cals')->onDelete('cascade');
            $table->double('row_1st');
            $table->double('row_2nd');
            $table->double('row_3rd');
            $table->double('row_4th');
            $table->double('row_5th');
            $table->double('row_6th');
            $table->double('row_7th');
            $table->double('row_8th');
            $table->double('row_9th');
            $table->double('row_10th');
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
        Schema::dropIfExists('bd_feasi_rnc_cal_costs');
    }
}
