<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasibilitySiteExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasibility_site_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_leadgeneration_id');
            $table->string('land_area', 255);
            $table->string('monthly_expense', 255);
            $table->timestamps();
            $table->foreign('bd_leadgeneration_id')->references('id')->on('bd_lead_generations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_feasibility_site_expenses');
    }
}
