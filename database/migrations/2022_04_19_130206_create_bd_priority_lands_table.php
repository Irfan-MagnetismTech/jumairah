<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdPriorityLandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_priority_lands', function (Blueprint $table) {
            $table->id();
            $table->date('applied_date');
            $table->year('year');
            $table->integer('month');
            $table->decimal('estimated_total_cost', 20,2);
            $table->decimal('estimated_total_sales_value', 20, 2);
            $table->decimal('expected_total_profit', 20, 2);
            $table->integer('entry_by');
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
        Schema::dropIfExists('bd_priority_lands');
    }
}
