<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalLayerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_layer_details', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('approval_layer_id')->on('approval_layers')->references('id')->onDelete('cascade');
            $table->string('name');
            $table->string('layer_key');
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->integer('order_by');
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
        Schema::dropIfExists('approval_layer_details');
    }
}
