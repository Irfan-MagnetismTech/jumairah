<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdleadSideroadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdlead_sideroads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_lead_generation_id');
            $table->foreign('bd_lead_generation_id')->on('bd_lead_generations')->references('id')->onDelete('cascade');
            $table->double('feet');
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
        Schema::dropIfExists('bdlead_sideroads');
    }
}
