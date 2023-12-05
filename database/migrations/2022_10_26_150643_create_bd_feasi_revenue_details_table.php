<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiRevenueDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_revenue_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('revenue_id');
            $table->foreign('revenue_id')->on('bd_feasi_revenues')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('floor_id');
            $table->foreign('floor_id')->on('boq_floors')->references('id')->onDelete('cascade');
            $table->decimal('floor_sft', 20, 2);
            $table->decimal('rate', 20, 2);
            $table->decimal('total', 20, 2);
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
        Schema::dropIfExists('bd_feasi_revenue_details');
    }
}
