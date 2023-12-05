<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_revenues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->on('bd_lead_generations')->references('id')->onDelete('cascade');
            $table->string('user_id');
            $table->decimal('total_floor_sft')->default(0);
            $table->decimal('actual_story')->default(0);
            $table->decimal('proposed_saleable_sft')->default(0);
            $table->double('revenue_from_parking')->default(0);
            $table->decimal('total_amount')->default(0);
            $table->integer('mgc')->default(0);
            $table->decimal('avg_rate')->default(0);
            $table->decimal('proposed_far')->default(0);
            $table->decimal('actual_far')->default(0);
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
        Schema::dropIfExists('bd_feasi_revenues');
    }
}
