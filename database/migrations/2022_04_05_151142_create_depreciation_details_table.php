<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepreciationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depreciation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('depreciation_id');
            $table->integer('fixed_asset_id');
            $table->decimal('amount',20,2);
            $table->timestamps();
            $table->foreign('depreciation_id')->on('depreciations')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depreciation_details');
    }
}
