<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_requisitions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('delivery_date')->nullable();
            $table->integer('mtrf_no');
            $table->integer('mpr_no')->nullable();
            $table->integer('from_project_id');
            $table->integer('to_project_id');
            $table->string('reason')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('requested_by');
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
        Schema::dropIfExists('movement_requisitions');
    }
}
