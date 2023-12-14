<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flow_lines', function (Blueprint $table) {
            $table->id();
            $table->enum('line_type', ['header','line']); 
            $table->tinyInteger('is_net_income'); 
            $table->integer('visible_index'); 
            $table->string('printed_no'); 
            $table->string('line_text'); 
            $table->enum('value_type', ['D','C']); 
            $table->enum('balance_type', ['total','per_period','D','C']); 
            $table->nestedSet(); 
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
        Schema::dropIfExists('cash_flow_lines');
    }
}
