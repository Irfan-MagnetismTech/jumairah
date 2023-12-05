<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_projects', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('cs_id')
                ->constrained('cs', 'id')
                ->cascadeOnDelete();
            $table->foreignId('project_id')
                ->constrained('projects', 'id')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('cs_projects');
    }
}
