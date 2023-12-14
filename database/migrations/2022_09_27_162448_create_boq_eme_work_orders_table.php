<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_work_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->date('issue_date');
            $table->string('workorder_for');
            $table->unsignedBigInteger('boq_eme_cs_id');
            $table->string('workorder_no');
            $table->unsignedBigInteger('supplier_id');
            $table->string('deadline')->nullable();
            $table->text('description')->nullable();
            $table->text('involvement')->nullable();
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('prepared_by')->nullable();
            $table->longText('workrate')->nullable();
            $table->decimal('total_amount',12,4)->nullable();
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
        Schema::dropIfExists('boq_eme_work_orders');
    }
}
