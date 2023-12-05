<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->integer('purchase_order_detail_id');
            $table->integer('raw_material_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('unit_kg','10')->nullable();
            $table->decimal('unit_ltr','10')->nullable();
            $table->decimal('product_price','10')->nullable();
            $table->decimal('density','10')->nullable();
            $table->decimal('unite_price','10')->nullable();
            $table->decimal('discount_price','10')->nullable();
            $table->decimal('lc_cost','10')->nullable();
            $table->decimal('totalPrice','10')->nullable();
            $table->timestamps();
            $table->foreign('purchase_id')->on('purchases')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
}
