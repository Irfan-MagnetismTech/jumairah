<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('lead_id')->nullable();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('spouse_name')->nullable();
            $table->string('spouse_contact')->nullable();
            $table->date('dob');
            $table->date('marriage_anniversary')->nullable();
            $table->string('nationality');
            $table->string('profession');
            $table->string('present_address');
            $table->string('permanent_address');
            $table->string('email');
            $table->string('contact');
            $table->string('contact_alternate')->nullable();
            $table->string('nid')->nullable();
            $table->string('tin')->nullable();
            $table->string('picture')->nullable();
            $table->string('auth_name')->nullable();
            $table->string('auth_address')->nullable();
            $table->string('auth_contact')->nullable();
            $table->string('auth_email')->nullable();
            $table->string('auth_picture')->nullable();
            $table->string('client_profile')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
