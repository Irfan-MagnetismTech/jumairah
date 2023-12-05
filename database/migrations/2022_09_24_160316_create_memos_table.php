<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->id();
            $table->string('letter_title', 200);
            $table->date('letter_date');
            $table->foreignId('cost_center_id');
            $table->string('address_word_one');
            $table->foreignId('employee_id');
            $table->string('letter_subject');
            $table->string('address_word_two');
            $table->longText('letter_body');
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
        Schema::dropIfExists('memos');
    }
}
