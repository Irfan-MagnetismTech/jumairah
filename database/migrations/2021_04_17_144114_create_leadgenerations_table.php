<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leadgenerations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country_code')->nullable();
            $table->string('contact');
            $table->string('contact_alternate')->nullable();
            $table->string('country_code_two')->nullable();
            $table->string('country_code_three')->nullable();
            $table->string('contact_alternate_three')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->string('company_name')->nullable();
            $table->string('business_card')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_contact')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('nationality')->nullable();
            $table->date('lead_date');
            $table->string('lead_stage');
            $table->string('category');
            $table->string('source_type');
            $table->integer('referral_id')->nullable();
            $table->string('apartment_id');
            $table->string('offer_details')->nullable();
            $table->string('attachment')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('is_sold')->nullable();
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
        Schema::dropIfExists('leadgenerations');
    }
}
