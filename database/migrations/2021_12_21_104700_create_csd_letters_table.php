<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsdLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csd_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_title', 200);
            $table->date('letter_date');
            $table->foreignId('project_id');
            $table->string('address_word_one');
            $table->foreignId('sell_id');
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
        Schema::dropIfExists('csd_letters');
    }
}
