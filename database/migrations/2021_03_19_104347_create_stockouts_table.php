<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockouts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reason');
            $table->integer('warehouse_id');
            $table->string('issued_to');
            $table->integer('issued_to_id');
            $table->integer('section_id')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('entry_by_id');
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
        Schema::dropIfExists('stockouts');
    }
}
