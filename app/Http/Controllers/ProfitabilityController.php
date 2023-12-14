<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProfitabilityController extends Controller {
	public function index() {
		$projects = Project::all();

		return view( 'profitability.index', compact( 'projects' ) );
	}

	public function getDataByProject( Request $request ) {
		$project_id = $request->project_id;

		$projectDetails = Project::where( 'id', $project_id )->first();

		return response()->json( [
			'projectDetails' => $projectDetails,
		] );
	}
}
