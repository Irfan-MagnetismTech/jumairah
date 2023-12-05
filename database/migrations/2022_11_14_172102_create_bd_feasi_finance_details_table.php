<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiFinanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_finance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_feasi_finance_id');
            $table->foreign('bd_feasi_finance_id')->on('bd_feasi_finances')->references('id')->onDelete('cascade');
            $table->integer('schedule_no');
            $table->string('month');
            $table->string('amount')->nullable();
            $table->decimal('sales_revenue_inflow', 20,2);
            $table->decimal('cash_outflow', 20,2);
            $table->decimal('outflow_rate', 20,2);
            $table->decimal('inflow_rate', 20,2);
            $table->decimal('outflow', 20,2);
            $table->decimal('inflow', 20,2);
            $table->decimal('net', 20,2);
            $table->decimal('interest', 20,2);
            $table->decimal('cumulitive', 20,2);
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
        Schema::dropIfExists('bd_feasi_finance_details');
    }
}
