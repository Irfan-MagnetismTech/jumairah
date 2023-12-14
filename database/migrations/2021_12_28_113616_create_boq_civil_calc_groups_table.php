<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqCivilCalcGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_civil_calc_groups', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('boq_civil_calc_id')->nullable()->constrained('boq_civil_calcs')->nullOnDelete();
            $table->string('name')->nullable();
            $table->decimal('total')->default(0);
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
        Schema::dropIfExists('boq_civil_calc_groups');
    }
}
