<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')->on('warehouses')->references('id')->onDelete('cascade');
            $table->decimal('total_value', 20, 2)->nullable();
            $table->decimal('per_mounth_rent', 20, 2)->nullable();
            $table->decimal('adjusted_amount', 20, 2)->nullable();
            $table->decimal('advance', 20, 2)->nullable();
            $table->decimal('duration', 20, 2)->nullable();
            $table->string('owner_name');
            $table->string('owner_contact');
            $table->string('owner_address');
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
        Schema::dropIfExists('warehouse_details');
    }
}
