<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loanable_type')->nullable();
            $table->integer('loanable_id')->nullable();
            $table->string('loan_type')->nullable();
            $table->string('loan_number')->nullable();
            $table->decimal('sanctioned_limit',20,2)->nullable();
            $table->date('opening_date')->nullable();
            $table->date('maturity_date')->nullable();
            $table->decimal('interest_rate',20,2)->nullable();
            $table->integer('total_installment')->nullable();
            $table->decimal('sanctioned_limit',20,2)->nullable();
            $table->string('description')->nullable();
            $table->string('loan_purpose')->nullable();
            $table->integer('project_id')->nullable();
            $table->date('emi_date')->nullable();
            $table->decimal('emi_amount',20,2)->nullable();

            $table->date('start_date')->nullable();
            $table->decimal('installment_size',20,2)->nullable();
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
        Schema::dropIfExists('loans');
    }
}
