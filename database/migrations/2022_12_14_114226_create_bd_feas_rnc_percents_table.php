<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasRncPercentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feas_rnc_percents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bd_lead_generation_id')->constrained('bd_lead_generations', 'id')->cascadeOnDelete();
            $table->unsignedBigInteger('applied_by');
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
        Schema::dropIfExists('bd_feas_rnc_percents');
    }
}
