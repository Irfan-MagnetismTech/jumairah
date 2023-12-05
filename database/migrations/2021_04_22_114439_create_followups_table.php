<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leadgeneration_id');
            $table->integer('followup_id')->nullable();
            $table->string('activity_type');
            $table->date('date');
            $table->date('next_followup_date')->nullable();
            $table->string('time_from');
            $table->string('time_till');
            $table->string('reason');
            $table->string('feedback');
            $table->string('remarks')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();

            $table->foreign('leadgeneration_id')->on('leadgenerations')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followups');
    }
}
