<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_letters', function (Blueprint $table) {
            $table->id();
            $table->uuid('com_id')->nullable();

            $table->string('letter_no')->unique();
            $table->date('letter_issue_date');
            $table->string('employee_name');
            $table->text('employee_address');
            $table->string('employee_department');
            $table->string('employee_designation');
            $table->string('employee_job_location');
            $table->date('employee_joining_date');
            $table->string('posted_to_company_name');
            $table->text('terms_and_conditions');
            $table->string('letter_issuer_name');
            $table->string('letter_issuer_designation');
            $table->text('letter_carbon_copy_to');
            $table->string('letter_creator_id');

            $table->text('full_letter_body')->nullable();
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
        Schema::dropIfExists('appointment_letters');
    }
};
