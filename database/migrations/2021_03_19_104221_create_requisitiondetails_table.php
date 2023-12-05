<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitiondetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('requisition_id');
            $table->integer('floor_id')->nullable();
            $table->integer('material_id');
            $table->decimal('quantity', 20,2);
            $table->date('required_date')->nullable();
            $table->timestamps();
            $table->foreign('requisition_id')->on('requisitions')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requsitiondetails');
    }
}
