<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary;

use App\Boq\Departments\Sanitary\SanitaryLaborCost;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqSanitaryLaborCostRequest;
use App\Procurement\Unit;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanitaryLaborCostController extends Controller {

    function __construct()
    {
        $this->middleware('permission:boq-sanitary', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Project $project ) {
		$laborCostData = SanitaryLaborCost::latest()->get();
		return view( 'boq.departments.sanitary.labor.index', compact( 'laborCostData', 'project' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( Project $project ) {
		$units = Unit::orderBy( 'id' )->pluck( 'name', 'id' );
		$projectName = $project->name;
		return view( 'boq.departments.sanitary.labor.create', compact( 'units', 'project', 'projectName' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( BoqSanitaryLaborCostRequest $request ) {
		$project = session()->get( 'project_id' );
		try {
			$laborCostData = $request->only( 'name', 'unit_id', 'rate_per_unit' );

			DB::transaction( function () use ( $laborCostData ) {
				SanitaryLaborCost::create( $laborCostData );
			} );

			return redirect()->route( 'boq.project.departments.sanitary.labor-cost.index', $project )->with( 'message', 'Data has been inserted successfully' );
		} catch ( QueryException $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}
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
	 * @param  int  $SanitaryLaborCostId
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $project, $SanitaryLaborCostId ) {
		$units = Unit::orderBy( 'id' )->pluck( 'name', 'id' );
		$SanitaryLaborCostData = SanitaryLaborCost::where( 'id', $SanitaryLaborCostId )->first();
		return view( 'boq.departments.sanitary.labor.create', compact( 'units', 'SanitaryLaborCostData' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $SanitaryLaborCostId
	 * @return \Illuminate\Http\Response
	 */
	public function update( BoqSanitaryLaborCostRequest $request, SanitaryLaborCost $SanitaryLaborCostId ) {
		$SanitaryLaborCost = SanitaryLaborCost::where( 'id', $SanitaryLaborCostId )->first();
		$project = session()->get( 'project_id' );
		try {
			$SanitaryLaborCostData = $request->only( 'name', 'unit_id', 'rate_per_unit' );

			DB::transaction( function () use ( $SanitaryLaborCost, $SanitaryLaborCostData ) {
				$SanitaryLaborCost->update( $SanitaryLaborCostData );
			} );

			return redirect()->route( 'boq.project.departments.sanitary.labor-cost.index', $project )->with( 'message', 'Data has been inserted successfully' );
		} catch ( QueryException $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $SanitaryLaborCostId ) {
		$SanitaryLaborCost = SanitaryLaborCost::where( 'id', $SanitaryLaborCostId )->first();
		$project = session()->get( 'project_id' );
		try {
			$SanitaryLaborCost->delete();
			return redirect()->route( 'boq.project.departments.sanitary.labor-cost.index', $project )->with( 'message', 'Data has been deleted successfully' );
		} catch ( QueryException $e ) {
			return redirect()->route( 'boq.project.departments.sanitary.labor-cost.index', $project )->withErrors( $e->getMessage() );
		}
	}
}
