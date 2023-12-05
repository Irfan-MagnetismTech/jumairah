<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionSheetsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'conversion_sheets', function ( Blueprint $table ) {
			$table->id();
			$table->foreignId( 'project_id' )->constrained( 'projects' )->onDelete( 'cascade' );
			$table->foreignId( 'material_id' )->constrained( 'nested_materials' )->onDelete( 'cascade' );
			$table->string( 'boq_floor_id' )->nullable();
			$table->date( 'conversion_date' );
			$table->decimal( 'boq_qty' );
			$table->decimal( 'changed_qty' );
			$table->decimal( 'final_qty' );
			$table->string( 'remarks' )->nullable();
            $table->enum('budget_type', ['material', 'material-labour', 'labour', 'other'])->default('material');
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'conversion_sheets' );
	}
}
