<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleactivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saleactivities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_id');
            $table->string('activity_type');
            $table->date('date');
            $table->string('time_from');
            $table->string('time_till');
            $table->string('reason');
            $table->string('feedback');
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('sell_id')->on('sells')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saleactivities');
    }
}
