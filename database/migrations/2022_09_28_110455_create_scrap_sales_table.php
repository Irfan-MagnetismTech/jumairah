<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_sales', function (Blueprint $table) {
            $table->id();
            $table->string('gate_pass');
            $table->unsignedBigInteger('scrap_cs_id');
            $table->unsignedBigInteger('cost_center_id');
            $table->string('sgs');
            $table->unsignedBigInteger('supplier_id');
            $table->date('applied_date');
            $table->decimal('grand_total',10,4);
            $table->unsignedBigInteger('applied_by');
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
        Schema::dropIfExists('scrap_sales');
    }
}
