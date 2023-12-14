<?php

namespace App\Http\Controllers\Boq;

use App\Boq\Configurations\BoqFloor;
use App\Boq\Configurations\BoqFloorType;
use App\Boq\Departments\Eme\BoqEmeBudget;
use App\Boq\Departments\Eme\BoqEmeCalculation;
use App\Boq\Departments\Sanitary\SanitaryBudgetSummary;
use App\Boq\Projects\BoqFloorProject;
use App\Http\Controllers\Controller;
use App\Project;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\View\View;

class BoqController extends Controller {
	private const DYNAMIC_FLOOR_TYPES = ['basement', 'floor'];

	/**
	 * Creates BoqFloorProject
	 *
	 * @param Project $project
	 */
	public function index( Project $project ) {
		try {
			$project->load( 'boqFloorProjects.floor.floor_type' );
			$boq_floors = BoqFloor::orderBy( 'id' )->with( 'floor_type' )->get()->groupBy( 'type_id' );
			$boq_floor_types = BoqFloorType::orderBy( 'id' )->get()->pluck( 'name', 'id' );

			if ( $boq_floors->count() === 0 || $boq_floor_types->count() === 0 ) {
				return redirect()->route( 'boq.configurations.floors.create' )->withErrors( 'Please create floor types and floors first.' );
			}

			if ( $project->boqFloorProjects->whereIn( 'floor.floor_type.name', self::DYNAMIC_FLOOR_TYPES )->count() != ( $project->basement + $project->storied ) ) {
				$floor_count = ['basement' => $project->basement, 'floor' => $project->storied];

				$project->boqFloorProjects()->delete();

				if ( !empty( $boq_floor_types ) ) {
					foreach ( $boq_floor_types as $boq_floor_type_id => $boq_floor_type_name ) {
						$filtered_boq_floors = $boq_floors->get( $boq_floor_type_id );

						if ( !empty( $filtered_boq_floors ) ) {
							foreach ( $filtered_boq_floors as $index => $filtered_boq_floor ) {
								if ( in_array( $boq_floor_type_name, self::DYNAMIC_FLOOR_TYPES ) && $index >= $floor_count[$boq_floor_type_name] ) {
									break;
								}

								BoqFloorProject::create( [
									'project_id'           => $project->id,
									'floor_id'             => $filtered_boq_floor->id,
									'area'                 => $project->boqFloorProjects->where( 'floor_id', $filtered_boq_floor->id )?->first()?->area ?? 0,
									'boq_floor_project_id' => "p-{$project->id}-f-{$filtered_boq_floor->id}",
								] );
							}
						}
					}
				}
			}

			$total_civil_cost = $project->boqCivilBudgets()->sum( 'total_amount' );

			$BoqEmeCalculationDetails = BoqEmeCalculation::get();

			return view( 'boq.projects.index', compact( 'project', 'total_civil_cost', 'BoqEmeCalculationDetails' ) );
		} catch ( \Exception $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}
	}

	public function abstractSheet( Project $project ) {
		try {

			$total_area = $project->boqFloorProjects()->sum( 'area' );

			if ( (int) $total_area === 0 ) {
				return redirect()->route( 'boq.project.configurations.areas.index', ['project' => $project->id] )
					->withError( 'Please add area for project' );
			}

			$all_cost_summary = $project->boqCivilBudgets()
				->selectRaw( "*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
					"SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
					"SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount, " .
					"SUM(CASE WHEN budget_type = 'other' THEN total_amount ELSE 0 END) AS other_total_cost" )
				->get();
			//dd($all_cost_summary);

			$total_cost = $all_cost_summary->sum( function ( $sheet ) {
				return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount + $sheet->other_total_cost;
			} );

			$all_cost_summary = $all_cost_summary->first();

			/*__For Sanitery total Budget __*/
			$sanitery_total = ( $project->sanitaryBudgetSummary->total_amount ?? 0 ) + ( $project->sanitaryBudgetSummaryIncremental->sum( 'total_amount' ) ?? 0 );
			/*__For EME Doubt total Budget __*/
			$eme_total = BoqEmeBudget::where( 'project_id', $project->id )->get()->sum( 'amount' ) ?? 0;

			$civil_price_escalations = $project->boqRevisedBudgets()
				->where( 'escalation_no', '!=', 0 )
				->where( 'budget_for', 'civil' )
				->selectRaw( "escalation_no, SUM(amount_after_revised) AS total_amount, SUM(IFNULL(increased_or_decreased_amount, 0)) AS changed_total_amount" )
				->groupBy( 'escalation_no' )
				->get();

			$sanitary_price_escalation = SanitaryBudgetSummary::where( 'project_id', $project->id )
				->where( 'type', '=', '1' )
				->get();

			return view( 'boq.projects.construction-abstract-sheet', compact( 'project', 'all_cost_summary',
				'total_cost', 'total_area', 'sanitery_total', 'eme_total', 'civil_price_escalations', 'sanitary_price_escalation' ) );
		} catch ( \Exception $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}
	}

	public function costSummarySheetCivil( Project $project ) {

		try {

			$project->load( 'boqFloorProjects.floor.floor_type' );
			$boq_floors = BoqFloor::orderBy( 'id' )->with( 'floor_type' )->get()->groupBy( 'type_id' );
			$boq_floor_types = BoqFloorType::orderBy( 'id' )->get()->pluck( 'name', 'id' );

			if ( $boq_floors->count() === 0 || $boq_floor_types->count() === 0 ) {
				return redirect()->route( 'boq.configurations.floors.create' )->withErrors( 'Please create floor types and floors first.' );
			}

			if ( $project->boqFloorProjects->whereIn( 'floor.floor_type.name', self::DYNAMIC_FLOOR_TYPES )->count() != ( $project->basement + $project->storied ) ) {
				$floor_count = ['basement' => $project->basement, 'floor' => $project->storied];

				$project->boqFloorProjects()->delete();

				if ( !empty( $boq_floor_types ) ) {
					foreach ( $boq_floor_types as $boq_floor_type_id => $boq_floor_type_name ) {
						$filtered_boq_floors = $boq_floors->get( $boq_floor_type_id );

						if ( !empty( $filtered_boq_floors ) ) {
							foreach ( $filtered_boq_floors as $index => $filtered_boq_floor ) {
								if ( in_array( $boq_floor_type_name, self::DYNAMIC_FLOOR_TYPES ) && $index >= $floor_count[$boq_floor_type_name] ) {
									break;
								}

								BoqFloorProject::create( [
									'project_id'           => $project->id,
									'floor_id'             => $filtered_boq_floor->id,
									'area'                 => $project->boqFloorProjects->where( 'floor_id', $filtered_boq_floor->id )?->first()?->area ?? 0,
									'boq_floor_project_id' => "p-{$project->id}-f-{$filtered_boq_floor->id}",
								] );
							}
						}
					}
				}
			}

			$total_civil_cost = $project->boqCivilBudgets()->sum( 'total_amount' );

			$BoqEmeCalculationDetails = BoqEmeCalculation::get();

			$all_cost_summary = $project->boqCivilBudgets()
				->selectRaw( "*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
					"SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
					"SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount, " .
					"SUM(CASE WHEN budget_type = 'other' THEN total_amount ELSE 0 END) AS other_total_cost" )
				->get();

			// get all total budget for pile work floor type for material budget

			$total_cost = $all_cost_summary->sum( function ( $sheet ) {
				return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount + $sheet->other_total_cost;
			} );

			$all_cost_summary = $all_cost_summary->first();

			// piling work
			$boq_floor_type = BoqFloorType::where( 'name', 'pile' )->first();
			$material_piling_amount = $project->boqCivilBudgets()->where( 'boq_floor_type_id', $boq_floor_type->id )
				->where( 'budget_type', 'material' )->sum( 'total_amount' );
			$material_piling_budget_id = $project->boqCivilBudgets()
				->where( 'budget_type', 'material' )
				->where( 'boq_floor_type_id', $boq_floor_type->id )->first();

			$labour_piling_budget_id = $project->boqCivilBudgets()
				->where( 'budget_type', 'labour' )
				->where( 'boq_floor_type_id', $boq_floor_type->id )->first();

			$all_cost_summary->material_total_amount = ( $all_cost_summary->material_total_amount - $material_piling_amount );

			$labour_piling_amount = $project->boqCivilBudgets()->where( 'boq_floor_type_id', $boq_floor_type->id )
				->where( 'budget_type', 'labour' )->sum( 'total_amount' );
			$all_cost_summary->labour_total_amount = ( $all_cost_summary->labour_total_amount - $labour_piling_amount );
			// piling work

			//other related cost groupby cost head and sum of amount
			$other_related_costs = $project->boqCivilBudgets()->where( 'budget_type', 'other' )->orderBy( 'cost_head' )->get()
				->groupBy( 'cost_head' )->map( function ( $item ) {
				return $item->sum( 'total_amount' );
			} );

			return view( 'boq.projects.construction-cost-summary-civil', compact( 'project', 'total_civil_cost',
				'BoqEmeCalculationDetails', 'all_cost_summary', 'total_cost', 'material_piling_amount', 'labour_piling_amount',
				'other_related_costs', 'material_piling_budget_id', 'labour_piling_budget_id' ) );
		} catch ( \Exception $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}

	}

	public function downloadAbstractSheet( Project $project ) {

		try {

			$total_area = $project->boqFloorProjects()->sum( 'area' );

			if ( (int) $total_area === 0 ) {
				return redirect()->route( 'boq.project.configurations.areas.index', ['project' => $project->id] )
					->withError( 'Please add area for project' );
			}

			$all_cost_summary = $project->boqCivilBudgets()
				->selectRaw( "*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
					"SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
					"SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount, " .
					"SUM(CASE WHEN budget_type = 'other' THEN total_amount ELSE 0 END) AS other_total_cost" )
				->get();
			//dd($all_cost_summary);

			$total_cost = $all_cost_summary->sum( function ( $sheet ) {
				return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount + $sheet->other_total_cost;
			} );

			$all_cost_summary = $all_cost_summary->first();

			/*__For Sanitery total Budget __*/
			$sanitery_total = ( $project->sanitaryBudgetSummary->total_amount ?? 0 ) + ( $project->sanitaryBudgetSummaryIncremental->sum( 'total_amount' ) ?? 0 );
			/*__For EME Doubt total Budget __*/
			$eme_total = BoqEmeCalculation::get()->sum( 'total_amount' ) ?? 0;

			return PDF::loadview( 'boq.projects.download-construction-abstract-sheet', compact(
				'project', 'all_cost_summary', 'total_cost', 'total_area', 'sanitery_total', 'eme_total'
			) )->stream( 'construction-abstract-sheet.pdf' );

		} catch ( \Exception $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}

	}

	public function downloadCostSummarySheetCivil( Project $project ) {

		try {

			$project->load( 'boqFloorProjects.floor.floor_type' );
			$boq_floors = BoqFloor::orderBy( 'id' )->with( 'floor_type' )->get()->groupBy( 'type_id' );
			$boq_floor_types = BoqFloorType::orderBy( 'id' )->get()->pluck( 'name', 'id' );

			if ( $boq_floors->count() === 0 || $boq_floor_types->count() === 0 ) {
				return redirect()->route( 'boq.configurations.floors.create' )->withErrors( 'Please create floor types and floors first.' );
			}

			if ( $project->boqFloorProjects->whereIn( 'floor.floor_type.name', self::DYNAMIC_FLOOR_TYPES )->count() != ( $project->basement + $project->storied ) ) {
				$floor_count = ['basement' => $project->basement, 'floor' => $project->storied];

				$project->boqFloorProjects()->delete();

				if ( !empty( $boq_floor_types ) ) {
					foreach ( $boq_floor_types as $boq_floor_type_id => $boq_floor_type_name ) {
						$filtered_boq_floors = $boq_floors->get( $boq_floor_type_id );

						if ( !empty( $filtered_boq_floors ) ) {
							foreach ( $filtered_boq_floors as $index => $filtered_boq_floor ) {
								if ( in_array( $boq_floor_type_name, self::DYNAMIC_FLOOR_TYPES ) && $index >= $floor_count[$boq_floor_type_name] ) {
									break;
								}

								BoqFloorProject::create( [
									'project_id'           => $project->id,
									'floor_id'             => $filtered_boq_floor->id,
									'area'                 => $project->boqFloorProjects->where( 'floor_id', $filtered_boq_floor->id )?->first()?->area ?? 0,
									'boq_floor_project_id' => "p-{$project->id}-f-{$filtered_boq_floor->id}",
								] );
							}
						}
					}
				}
			}

			$total_civil_cost = $project->boqCivilBudgets()->sum( 'total_amount' );

			$BoqEmeCalculationDetails = BoqEmeCalculation::get();

			$all_cost_summary = $project->boqCivilBudgets()
				->selectRaw( "*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
					"SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
					"SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount, " .
					"SUM(CASE WHEN budget_type = 'other' THEN total_amount ELSE 0 END) AS other_total_cost" )
				->get();

			// get all total budget for pile work floor type for material budget

			$total_cost = $all_cost_summary->sum( function ( $sheet ) {
				return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount + $sheet->other_total_cost;
			} );

			$all_cost_summary = $all_cost_summary->first();

			// piling work
			$boq_floor_type = BoqFloorType::where( 'name', 'pile' )->first();
			$material_piling_amount = $project->boqCivilBudgets()->where( 'boq_floor_type_id', $boq_floor_type->id )
				->where( 'budget_type', 'material' )->sum( 'total_amount' );
			$material_piling_budget_id = $project->boqCivilBudgets()
				->where( 'budget_type', 'material' )
				->where( 'boq_floor_type_id', $boq_floor_type->id )->first();

			$labour_piling_budget_id = $project->boqCivilBudgets()
				->where( 'budget_type', 'labour' )
				->where( 'boq_floor_type_id', $boq_floor_type->id )->first();

			$all_cost_summary->material_total_amount = ( $all_cost_summary->material_total_amount - $material_piling_amount );

			$labour_piling_amount = $project->boqCivilBudgets()->where( 'boq_floor_type_id', $boq_floor_type->id )
				->where( 'budget_type', 'labour' )->sum( 'total_amount' );
			$all_cost_summary->labour_total_amount = ( $all_cost_summary->labour_total_amount - $labour_piling_amount );
			// piling work

			//other related cost groupby cost head and sum of amount
			$other_related_costs = $project->boqCivilBudgets()->where( 'budget_type', 'other' )->orderBy( 'cost_head' )->get()
				->groupBy( 'cost_head' )->map( function ( $item ) {
				return $item->sum( 'total_amount' );
			} );

//            return view('boq.projects.construction-cost-summary-civil', compact('project', 'total_civil_cost',
//                'BoqEmeCalculationDetails','all_cost_summary','total_cost','material_piling_amount','labour_piling_amount',
//                'other_related_costs','material_piling_budget_id','labour_piling_budget_id'));

			return PDF::loadview( 'boq.projects.download-construction-cost-summary-civil', compact(
				'project', 'total_civil_cost',
				'BoqEmeCalculationDetails', 'all_cost_summary', 'total_cost', 'material_piling_amount', 'labour_piling_amount',
				'other_related_costs', 'material_piling_budget_id', 'labour_piling_budget_id'
			) )->stream( 'civil-cost-summary-sheet.pdf' );

		} catch ( \Exception $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}

	}

}
