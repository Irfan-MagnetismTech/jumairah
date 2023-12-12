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
        Schema::create('bank_branch_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_id');
            $table->string('branch');
            $table->string('address');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('account_type');
            $table->string('status');
            $table->uuid('com_id')->nullable();
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
        Schema::dropIfExists('bank_branch_infos');
    }
};
