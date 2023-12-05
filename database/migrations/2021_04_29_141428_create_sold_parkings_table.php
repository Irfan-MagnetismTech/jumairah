<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_parkings', function (Blueprint $table) {
            $table->id();
            $table->string('parking_composite');
            $table->decimal('parking_rate', $precision = 18, $scale = 2);
            $table->unsignedBigInteger('sell_id');
            $table->foreign('sell_id')->on('sells')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('sold_parkings');
    }
}
