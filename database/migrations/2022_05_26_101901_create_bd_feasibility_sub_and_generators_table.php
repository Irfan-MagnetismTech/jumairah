<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasibilitySubAndGeneratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasibility_sub_and_generators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_leadgeneration_id');
            $table->foreign('bd_leadgeneration_id')->references('id')->on('bd_lead_generations')->onDelete('cascade');
            $table->decimal('kva', 20,2);
            $table->integer('generator_rate')->nullable();
            $table->integer('sub_station_rate')->nullable();
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
        Schema::dropIfExists('bd_feasibility_sub_and_generators');
    }
}
