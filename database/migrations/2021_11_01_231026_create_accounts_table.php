<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('balance_and_income_line_id');
            $table->integer('equity_column_id')->nullable();
            $table->integer('parent_account_id')->nullable();
            $table->string('account_name');
            $table->string('account_code')->nullable();
            $table->smallInteger('account_type');
            $table->string('official_code')->nullable(); //income tax code
            $table->string('accountable_type')->nullable();
            $table->integer('accountable_id')->nullable();
            $table->string('loan_type')->nullable();
            $table->tinyInteger('is_archived')->nullable();
            $table->dateTime('inserted_at')->nullable();
            $table->string('inserted_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
