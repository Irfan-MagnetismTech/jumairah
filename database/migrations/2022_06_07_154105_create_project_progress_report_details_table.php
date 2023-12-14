<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectProgressReportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_progress_report_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pp_report_id');
            $table->foreign('pp_report_id')->references('id')->on('project_progress_reports')->onDelete('cascade');
            $table->integer('cost_center_id');
            $table->date('date_of_inception');
            $table->date('date_of_completion');
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
        Schema::dropIfExists('project_progress_report_details');
    }
}
