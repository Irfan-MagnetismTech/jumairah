<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('mpr_no', 100);
            $table->integer('cost_center_id');
            $table->date('applied_date');
            $table->integer('requisition_by');
            $table->unsignedBigInteger('approval_layer_id');
            $table->string('status', 255)->nullable();
            $table->text('note')->nullable();
            $table->text('remarks')->nullable();
            $table->string('condition', 50)->nullable();
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
        Schema::dropIfExists('requisitions');
    }
}
