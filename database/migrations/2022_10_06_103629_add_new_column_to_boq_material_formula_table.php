<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToBoqMaterialFormulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boq_works', function (Blueprint $table) {
            if (!Schema::hasColumn('boq_works', 'labour_budget_type')){
                $table->tinyInteger('labour_budget_type')->after('is_reinforcement')->default(0);
            };
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boq_works', function (Blueprint $table) {
            $table->dropColumn(['labour_budget_type']);
        });
    }
}
