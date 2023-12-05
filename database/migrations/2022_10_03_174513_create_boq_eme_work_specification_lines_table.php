<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeWorkSpecificationLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_work_specification_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boq_eme_work_specification_id');
            $table->foreign('boq_eme_work_specification_id')->on('boq_eme_work_specifications')->references('id')->onDelete('cascade');
            $table->text('title')->nullable();
            $table->text('value')->nullable();
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
        Schema::dropIfExists('boq_eme_work_specification_lines');
    }
}
