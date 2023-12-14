<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parking_id');
            $table->string('parking_name');
            $table->string('parking_owner');
            $table->string('parking_composite'); //parkingname+$parking->id
            $table->timestamps();
            $table->foreign('parking_id')->on('parkings')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parking_details');
    }
}
