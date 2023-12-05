<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdLeadGenerationPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_lead_generation_pictures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_lead_generation_id');
            $table->string('picture', 255);
            $table->foreign('bd_lead_generation_id')->on('bd_lead_generations')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('bd_lead_generation_pictures');
    }
}
