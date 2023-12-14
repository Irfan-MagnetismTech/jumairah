<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_receives', function (Blueprint $table) {
            $table->id();

            $table->string('po_no', 100);
            $table->integer('mrr_no');
            $table->unsignedBigInteger('cost_center_id');
            $table->date('date');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('applied_by');
            $table->unsignedBigInteger('requisition_id')->nullable();
            $table->string('quality')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('material_receives');
    }
}
