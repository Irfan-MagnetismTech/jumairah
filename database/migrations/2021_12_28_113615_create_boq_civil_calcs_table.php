<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqCivilCalcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_civil_calcs', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('work_id')->nullable()->constrained('boq_works')->nullOnDelete();

            $table->string('boq_floor_id')->nullable();
            $table->foreign('boq_floor_id')
                ->nullable()
                ->references('boq_floor_project_id')
                ->on('boq_floor_projects')
                ->nullOnDelete();

            $table->string('calculation_type')->nullable();
            $table->string('work_type')->nullable();
            $table->decimal('total')->default(0);
            $table->decimal('secondary_total')->default(0);
            $table->decimal('secondary_total_fx')->default(0);
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
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
        Schema::dropIfExists('boq_civil_calcs');
    }
}
