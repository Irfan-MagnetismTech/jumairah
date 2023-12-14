<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_adjustments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('cost_center_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('mrr_id')->nullable();
            $table->unsignedBigInteger('iou_id');
            $table->double('grand_total',20,2);
            $table->double('balance',20,2);
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
        Schema::dropIfExists('advance_adjustments');
    }
}
