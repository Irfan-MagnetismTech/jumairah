<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiCtcRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_ctc_rates', function (Blueprint $table) {
            $table->id();
            $table->string('department_id');
            // $table->foreign('department_id')->on('departments')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')->on('designations')->references('id')->onDelete('cascade');
            $table->string('employment_nature')->nullable();
            $table->integer('percent_sharing')->nullable();
            $table->integer('number')->nullable();
            $table->integer('gross_salary')->nullable();
            $table->integer('mobile_bill')->nullable();
            $table->integer('providend_fund')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('Long_term_benefit')->nullable();
            $table->integer('canteen_expense')->nullable();
            $table->integer('earned_encashment')->nullable();
            $table->integer('others')->nullable();
            $table->integer('total_payable')->nullable();
            $table->integer('total_effect')->nullable();
            $table->decimal('percent_on_slry',7,2)->nullable();
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
        Schema::dropIfExists('bd_feasi_ctc_rates');
    }
}
