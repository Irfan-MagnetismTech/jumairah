<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdInventoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_inventory_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_inventory_id');
            $table->unsignedBigInteger('cost_center_id');
            $table->integer('land_size')->nullable();
            $table->string('ratio')->nullable();
            $table->integer('total_units')->nullable();
            $table->integer('lo_units')->nullable();
            $table->integer('lo_space')->nullable();
            $table->integer('rfpl_units')->nullable();
            $table->integer('rfpl_space')->nullable();
            $table->integer('margin')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('parking')->nullable();
            $table->integer('utility')->nullable();
            $table->integer('other_benefit')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('signing_money');
            $table->integer('inventory_value');
            $table->foreign('bd_inventory_id')->on('bd_inventories')->references('id')->onDelete('cascade');
            $table->foreign('cost_center_id')->on('cost_centers')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('bd_inventory_details');
    }
}
