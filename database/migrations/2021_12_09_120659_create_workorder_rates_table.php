<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkorderRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorder_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workorder_id')->constrained('workorders', 'id')->cascadeOnDelete();
            $table->string('work_level');
            $table->text('work_description')->nullable();
            $table->float('work_quantity')->nullable();
            $table->string('work_unit')->nullable();
            $table->float('work_rate')->nullable();
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
        Schema::dropIfExists('workorder_rates');
    }
}
