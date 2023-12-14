<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Departments\Eme\BoqEmeRate;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;

class BoqElectricalProjectWiseMaterialPriceController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Project $project ) {
		$material_price = BoqEmeRate::groupBy( 'material_id' )
			->with( 'NestedMaterial' )
			->get();

		$material_price = $material_price->sortBy( 'NestedMaterial.name' );
		// dd( $material_price );
		return view( 'boq.departments.electrical.configurations.electricalprojectwisematerialprice.index', compact( 'material_price', 'project' ) );
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
	public function edit( $id ) {
		//
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
