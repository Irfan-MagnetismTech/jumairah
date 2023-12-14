<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqFloorTypeBoqWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_floor_type_boq_works', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('boq_floor_type_id')
                ->constrained('boq_floor_types')
                ->onDelete('cascade');
            $table->foreignId('boq_work_id')
                ->constrained('boq_works')
                ->onDelete('cascade');
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
        Schema::dropIfExists('boq_floor_type_boq_works');
    }
}
