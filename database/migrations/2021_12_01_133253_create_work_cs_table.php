<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_cs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('involvement')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->string('cs_type')->nullable();
            $table->string('reference_no')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('is_for_all')->default(0)->comment('0=>not for all , 1=> for all');
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->integer('is_saved')->nullable()->comment('0 => not saved , 1 => saved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_cs');
    }
}
