<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentShiftingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_shifting_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_shifting_id');
            $table->string('parking_composite')->nullable();
            $table->decimal('parking_rate', 20,2)->nullable();
            $table->integer('sell_id')->nullable();
            $table->timestamps();
            $table->foreign('apartment_shifting_id')->on('apartment_shiftings')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_shifting_details');
    }
}
