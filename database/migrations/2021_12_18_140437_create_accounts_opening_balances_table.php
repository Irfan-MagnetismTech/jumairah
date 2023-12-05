<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsOpeningBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_opening_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->date('date')->nullable();
            $table->decimal('dr_amount', 20, 2)->nullable();
            $table->decimal('cr_amount', 20, 2)->nullable();
            $table->bigInteger('cost_center_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('accounts_opening_balances');
    }
}
