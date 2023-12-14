<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasRncPercentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feas_rnc_percent_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bd_feas_rnc_percent_id')->constrained('bd_feas_rnc_percents', 'id')->cascadeOnDelete();
            $table->integer('type')->default(0)->comment('0=>cost,1=>revenue');
            $table->double('project_year');
            $table->string('cent_1st');
            $table->string('cent_2nd');
            $table->string('cent_3rd');
            $table->string('cent_4th');
            $table->string('cent_5th');
            $table->string('cent_6th');
            $table->string('cent_7th');
            $table->string('cent_8th');
            $table->string('cent_9th');
            $table->string('cent_10th');
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
        Schema::dropIfExists('bd_feas_rnc_percent_details');
    }
}
