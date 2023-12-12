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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('nick_name')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('week_day')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('chairman_certificate_no')->nullable();
            $table->string('natinality')->nullable();
            $table->string('caste')->nullable();
            $table->string('identification_sign')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('vaccinated')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->tinyInteger('is_allow_pf')->default(0);
            $table->date('pf_date')->nullable();
            $table->tinyInteger('is_police_verify')->default(0);
            $table->tinyInteger('is_using_house')->default(0);
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->timestamps();
            // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_details');
    }
};
