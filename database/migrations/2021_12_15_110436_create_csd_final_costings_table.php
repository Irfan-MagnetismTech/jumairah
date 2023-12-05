<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsdFinalCostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csd_final_costings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->foreignId('apartment_id');
            $table->foreignId('sell_id');
            $table->string('status')->nullable()->comment('Accepted', 'Checked', 'Approved');
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
        Schema::dropIfExists('csd_final_costings');
    }
}
