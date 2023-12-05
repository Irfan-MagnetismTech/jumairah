<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqEmeWorkSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_eme_work_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boq_eme_work_order_id')->constrained('boq_eme_work_orders', 'id')->cascadeOnDelete();
            $table->text('topic')->nullable();
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
        Schema::dropIfExists('boq_eme_work_specifications');
    }
}
