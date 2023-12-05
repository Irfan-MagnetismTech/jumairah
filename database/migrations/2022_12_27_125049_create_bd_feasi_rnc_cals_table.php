<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdFeasiRncCalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_feasi_rnc_cals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bd_lead_generation_id')->constrained('bd_lead_generations', 'id')->cascadeOnDelete();
            $table->double('project_year');
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
        Schema::dropIfExists('bd_feasi_rnc_cals');
    }
}
