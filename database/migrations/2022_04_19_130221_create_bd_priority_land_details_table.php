<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdPriorityLandDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_priority_land_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bd_priority_land_id');
            $table->unsignedBigInteger('bd_lead_generation_details_id');
            $table->string('category');
            $table->decimal('margin', 20, 2);
            $table->decimal('cash_benefit', 20, 2);
            $table->string('type');
            $table->string('status');
            $table->date('expected_date');
            $table->decimal('estimated_cost', 20, 2);
            $table->decimal('estimated_sales_value', 20, 2);
            $table->decimal('expected_profit', 20, 2);
            $table->timestamps();
            $table->foreign('bd_priority_land_id')->on('bd_priority_lands')->references('id')->onDelete('cascade');
            $table->foreign('bd_lead_generation_details_id')->on('bd_lead_generation_details')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_priority_land_details');
    }
}
