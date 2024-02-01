<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('loan_type');
            $table->string('loan_amount');
            $table->string('loan_reason');
            $table->string('loan_duration');
            $table->integer('loan_installment');
            $table->string('loan_start_date');
            $table->string('loan_end_date');
            $table->string('loan_status')->default('pending');
            $table->integer('approved_by')->nullable();
            $table->string('approved_date')->nullable();
            $table->integer('left_amount')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->integer('interest_rate')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('loan_applications');
    }
}
