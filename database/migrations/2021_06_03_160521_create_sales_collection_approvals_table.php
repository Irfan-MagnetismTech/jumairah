<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCollectionApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_collection_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salecollection_id');
            $table->foreign('salecollection_id')->on('sales_collections')->references('id')->onDelete('cascade');
            $table->string('approval_status');
            $table->date('approval_date');
            $table->integer('bank_account_id')->nullable();
            $table->integer('sundry_creditor_account_id')->nullable();
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('sales_collection_approvals');
    }
}
