<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sgsf_no');
            $table->unsignedBigInteger('cost_center_id');
            $table->integer('applied_by');
            $table->string('status');
            $table->date('applied_date');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('scrap_forms');
    }
}
