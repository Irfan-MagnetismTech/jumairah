<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ious', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_center_id');
            $table->foreignId('supplier_id')->nullable();
            $table->integer('applied_by');
            $table->date('applied_date');
            $table->longText('iou_no')->nullable();
            $table->text('remarks');
            $table->string('status')->default(0);
            $table->string('po_no')->nullable();
            $table->unsignedBigInteger('requisition_id')->nullable();
            $table->integer('workorder_id')->nullable();
            $table->integer('boq_eme_work_order_id')->nullable();
            $table->decimal('total_amount',$precision = 18, $scale = 2)->nullable();
            $table->integer('type')->default(0)->comment('0=>employee,1=>supplier,2=>construction,3=>eme');
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
        Schema::dropIfExists('ious');
    }
}
