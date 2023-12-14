<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeWorkOtherFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_work_other_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boq_eme_work_order_id');
            $table->foreign('boq_eme_work_order_id')->on('boq_eme_work_orders')->references('id')->onDelete('cascade');
            $table->longText('special_function')->nullable();
            $table->longText('safety_feature')->nullable();
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
        Schema::dropIfExists('boq_eme_work_other_features');
    }
}
