<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqReinforcementMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_reinforcement_measurements', function (Blueprint $table) {
            $table->id();
            $table->integer('dia');
            $table->decimal('weight',20,4);
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
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
        Schema::dropIfExists('boq_reinforcement_measurements');
    }
}
