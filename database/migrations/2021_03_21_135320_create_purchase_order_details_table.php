<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->integer('material_id')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('quantity','10')->nullable();
            $table->decimal('unit_price','10')->nullable();
            $table->decimal('total_price','10')->nullable();
            $table->date('required_date');
            $table->timestamps();
            $table->foreign('purchase_order_id')->on('purchase_orders')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_details');
    }
}
