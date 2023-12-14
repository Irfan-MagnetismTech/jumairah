<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCollectionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_collection_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_collection_id');
            $table->string('particular');
            $table->decimal('amount', 18, 2); 
            $table->integer('installment_no')->nullable();
            $table->string('installment_composite')->nullable();
            $table->integer('applied_days')->nullable();
            $table->decimal('applied_amount', 18, 2)->nullable();
            $table->timestamps();
            $table->foreign('sales_collection_id')->on('sales_collections')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_collection_details');
    }
}
