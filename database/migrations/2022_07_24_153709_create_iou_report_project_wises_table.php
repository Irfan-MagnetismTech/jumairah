<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIouReportProjectWisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iou_report_project_wises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_center_id');
            $table->string('iou_date');
            $table->integer('project_wise_iou')->default(1);
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
        Schema::dropIfExists('iou_report_project_wises');
    }
}
