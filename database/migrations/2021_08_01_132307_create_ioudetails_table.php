<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIoudetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ioudetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iou_id');
            $table->foreign('iou_id')->on('ious')->references('id')->onDelete('cascade');
            $table->string('purpose');
            $table->integer('remarks');
            $table->bigInteger('amount');
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
        Schema::dropIfExists('ioudetails');
    }
}
