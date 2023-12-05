<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorders', function (Blueprint $table) {
            $table->id();
            $table->date('issue_date');
            $table->bigInteger('work_cs_id');
            $table->string('workorder_no');
            $table->bigInteger('supplier_id');
            $table->unsignedBigInteger('project_id');
            $table->string('deadline')->nullable();
            $table->text('description')->nullable();
            $table->text('involvement')->nullable();
            $table->string('remarks')->nullable();
            $table->bigInteger('prepared_by')->nullable();
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
        Schema::dropIfExists('workorders');
    }
}
