<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_form_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scrap_form_id');
            $table->foreign('scrap_form_id')->on('scrap_forms')->references('id')->onDelete('cascade');
            $table->integer('material_id');
            $table->integer('quantity');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('scrap_form_details');
    }
}
