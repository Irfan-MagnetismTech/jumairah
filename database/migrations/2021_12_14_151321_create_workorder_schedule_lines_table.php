<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkorderScheduleLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorder_schedule_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workorder_schedule_id')->constrained('workorder_schedules', 'id')->cascadeOnDelete();
            $table->text('work_status')->nullable();              
            $table->float('payment_ratio')->nullable();              
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
        Schema::dropIfExists('workorder_schedule_lines');
    }
}
