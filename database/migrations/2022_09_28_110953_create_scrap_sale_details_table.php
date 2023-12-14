<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scrap_sale_id');
            $table->foreign('scrap_sale_id')->on('scrap_sales   ')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('material_id');
            $table->double('rate');
            $table->double('quantity');
            $table->string('remarks');
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
        Schema::dropIfExists('scrap_sale_details');
    }
}
