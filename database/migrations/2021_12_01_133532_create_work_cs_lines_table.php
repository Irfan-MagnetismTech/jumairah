<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkCsLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_cs_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_cs_id')->constrained('work_cs', 'id')->cascadeOnDelete();
            $table->string('work_level')->nullable();
            $table->text('work_description')->nullable();
            $table->float('work_quantity')->nullable();
            $table->string('work_unit')->nullable();
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
        Schema::dropIfExists('work_cs_lines');
    }
}
