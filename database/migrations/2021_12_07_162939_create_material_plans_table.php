<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applied_by')->nullable();
            $table->foreignId('project_id');
            $table->date('from_date');
            $table->date('to_date')->nullable();
            $table->year('year')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->integer('month')->nullable();
            $table->integer('gm_approval_status')->nullable()->comment('0 = pending', '1=approved');
            $table->integer('user_id')->nullable();
            $table->integer('is_saved')->nullable()->comment('0 => not saved , 1 => saved');
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
        Schema::dropIfExists('material_plans');
    }
}
