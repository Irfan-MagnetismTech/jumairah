<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockreturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockreturns', function (Blueprint $table) {
            $table->id();
            $table->integer('stockout_id');
            $table->date('date');
            $table->integer('entry_by_id');
            $table->string('remarks');
            $table->integer('warehouse_id');
            $table->integer('section_id')->nullable();

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
        Schema::dropIfExists('stockreturns');
    }
}
