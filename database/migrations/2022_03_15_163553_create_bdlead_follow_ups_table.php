<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdleadFollowUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdlead_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_lead_generation_id');
            $table->string('remarks');
            $table->integer('followup_by');
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
        Schema::dropIfExists('bdlead_follow_ups');
    }
}
