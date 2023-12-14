<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkorderTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorder_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workorder_id')->constrained('workorders', 'id')->cascadeOnDelete();
            $table->text('general_terms')->nullable();
            $table->text('payment_terms')->nullable();            
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
        Schema::dropIfExists('workorder_terms');
    }
}
