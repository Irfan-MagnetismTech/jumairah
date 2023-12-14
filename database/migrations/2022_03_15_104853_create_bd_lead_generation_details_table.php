<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdLeadGenerationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_lead_generation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_lead_generation_id');
            $table->string('name');
            $table->string('mobile');
            $table->string('mail')->nullable();
            $table->string('present_address');
            $table->timestamps();
            $table->foreign('bd_lead_generation_id')->on('bd_lead_generations')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_lead_generation_details');
    }
}
