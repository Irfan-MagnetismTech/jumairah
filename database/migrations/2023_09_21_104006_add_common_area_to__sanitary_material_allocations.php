<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommonAreaToSanitaryMaterialAllocations extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'Sanitary_material_allocations', function ( Blueprint $table ) {
			$table->decimal( 'commonArea' )->nullable();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'Sanitary_material_allocations', function ( Blueprint $table ) {
			//
		} );
	}
}
