<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceAndIncomeLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_and_income_lines', function (Blueprint $table) {
            $table->id();
            $table->enum('line_type', ['base_header','balance_header','income_header','balance_line','income_line']);
            $table->integer('visible_index');
            $table->string('printed_no');
            $table->string('line_text');
            $table->integer('project_id')->nullable();
            $table->enum('value_type', ['D','C']);
            $table->nestedSet();
            $table->dateTime('inserted_at');
            $table->string('inserted_by');
            $table->dateTime('updated_at');
            $table->string('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_and_income_lines');
    }
}
