<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowLineAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flow_line_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_flow_line_id');
            $table->integer('account_id');
            $table->timestamps();
            $table->foreign('cash_flow_line_id')->on('cash_flow_lines')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_flow_line_assignments');
    }
}
