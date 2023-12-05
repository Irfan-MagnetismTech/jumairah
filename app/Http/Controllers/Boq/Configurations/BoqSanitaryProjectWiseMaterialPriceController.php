<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Departments\Sanitary\SanitaryMaterialRate;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;

class BoqSanitaryProjectWiseMaterialPriceController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Project $project ) {
		$material_price = SanitaryMaterialRate::groupBy( 'material_id' )
			->with( 'material' )
			->get();

		$material_price = $material_price->sortBy( 'material.name' );
		// dd( $material_price );
		return view( 'boq.departments.sanitary.configurations.sanitaryprojectwisematerialprice.index', compact( 'material_price', 'project' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Project $project, SanitaryMaterialRate $ProjectWiseMaterialPrice ) {
		$ProjectWiseMaterialPrice->load( 'material' );

		dd( $ProjectWiseMaterialPrice );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}
}
