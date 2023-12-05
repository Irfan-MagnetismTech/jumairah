<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_center_id');
            $table->foreignId('material_receive_report_id')->nullable();
            $table->foreignId('store_issue_id')->nullable();
            $table->foreignId('material_id');
            $table->decimal('previous_stock', 20, 2);
            $table->decimal('quantity', 20, 2);
            $table->decimal('present_stock', 20, 2);
            $table->decimal('average_cost', 20, 2);
            $table->date('date')->nullable();
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
        Schema::dropIfExists('stock_histories');
    }
}
