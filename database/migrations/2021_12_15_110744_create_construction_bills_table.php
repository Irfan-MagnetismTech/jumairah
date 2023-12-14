<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->nullable();
            $table->string('title')->nullable();
            $table->date('bill_received_date')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('cost_center_id')->nullable();
            $table->unsignedBigInteger('workorder_id')->nullable();
            $table->unsignedBigInteger('boq_eme_work_order_id')->nullable();
            $table->unsignedBigInteger('workorder_rate_id')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('reference_no')->nullable();
            $table->float('bill_amount')->nullable();
            $table->integer('percentage')->nullable();
            $table->text('work_type')->nullable();
            $table->text('remarks')->nullable();
            $table->bigInteger('prepared_by')->nullable();
            $table->year('year')->nullable();
            $table->integer('month')->nullable();
            $table->bigInteger('due_payable')->default(0);
            $table->integer('week')->nullable();
            $table->string('status')->nullable()->comment('Accepted', 'Checked', 'Approved');
            $table->integer('is_saved')->nullable()->comment('0 => not saved , 1 => saved');
            $table->integer('user_id')->nullable();
            $table->integer('type')->default(0)->comment('0=>construction,1=>eme');
            $table->decimal('adjusted_amount',20,5)->nullable();
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
        Schema::dropIfExists('construction_bills');
    }
}
