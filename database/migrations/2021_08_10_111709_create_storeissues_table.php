<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreissuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storeissues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_center_id');
            $table->integer('sin_no');
            $table->unsignedBigInteger('applied_by');
            $table->string('srf_no');
            $table->date('date');
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
        Schema::dropIfExists('storeissues');
    }
}
