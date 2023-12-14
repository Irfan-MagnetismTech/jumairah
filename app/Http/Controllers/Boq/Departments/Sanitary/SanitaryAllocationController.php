<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary;

use App\Boq\Departments\Sanitary\SanitaryAllocation;
use App\Boq\Departments\Sanitary\SanitaryLocationType;
use App\Boq\Departments\Sanitary\SanitaryMaterialAllocation;
use App\Http\Controllers\Controller;
use App\Http\Requests\SanitaryAllocationRequest;
use App\Project;
use App\SanitaryFormulaDetail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanitaryAllocationController extends Controller {

    function __construct()
    {
        $this->middleware('permission:boq-sanitary', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

	public function index( Project $project ) {
		$allocations = SanitaryAllocation::with( 'apartmentType' )->residential()->where( 'project_id', $project->id )->get()
			->groupBy( ['apartment_type', 'location_type'] );
		$allocationsCommercial = SanitaryAllocation::commercial()->where( 'project_id', $project->id )->get()
			->groupBy( ['floor_Type'] )
		//            ->groupBy(['floor_Type', 'location_type']);
			->map( function ( $item, $key ) {
				$first = $item->first();
				$commercialData['floor'] = $key;
				$commercialData['floor_no'] = $first->floor_no;
				$commercialData['typeWiseQuantity'] = $item->groupBy( 'location_type' )->flatten()->toArray();
				return $commercialData;
			} );

		//        dd($allocationsCommercial);
		return view( 'boq.departments.sanitary.sanitary-allocations.index', compact( 'project', 'allocations', 'allocationsCommercial' ) );
	}

	public function create( Project $project ) {
		//
	}

	public function sanitaryAllocationCreate( Project $project, $type ) {
		if ( $type == 'Commercial' ) {
			$types = SanitaryLocationType::where( 'type', 0 )->get();
			$formulaData = SanitaryFormulaDetail::with( 'material', 'sanitaryFormula' )
				->whereHas( 'sanitaryFormula', function ( $q ) {
					$q->where( 'location_for', 0 );
				} )->get();
		} else {
			$types = SanitaryLocationType::where( 'type', 1 )->get();
			$formulaData = SanitaryFormulaDetail::with( 'material', 'sanitaryFormula' )
				->whereHas( 'sanitaryFormula', function ( $q ) {
					$q->where( 'location_for', 1 );
				} )->get();
		}
		$formulas = $formulaData->groupBy( ['material_id', 'sanitaryFormula.location_type'] );
		//        dd($formulas);
		//                ->map(function ($item, $key) use($types){
		//                    foreach ($types as $type){
		//                        $locations = SanitaryFormulaDetail::whereHas('sanitaryFormula', function ($q)use($type){
		//                            $q->where('location_type',$type)->where('location_for',1);
		//                        })->where('material_id',$key )->first();
		//                        return $locations;
		//                    }
		//                });
		//            dd($formulas);
		//        dd($formulas->toArray(), $formulaData->groupBy(['material_id','sanitaryFormula.location_type'])->toArray());

		if ( $type == 'Residential' ) {
			return view( 'boq.departments.sanitary.sanitary-allocations.residentialCreate', compact( 'type', 'types', 'project', 'formulas' ) );
		} else {
			return view( 'boq.departments.sanitary.sanitary-allocations.commercialCreate', compact( 'type', 'types', 'project', 'formulas' ) );
		}
	}

	public function store( SanitaryAllocationRequest $request, Project $project ) {
		try {
			//            dd($request->all());
			$toiletArray = [];
			$basinArr = [];
			$urinalArr = [];
			$pantryArr = [];
			$CCToiletArr = [];
			$masterArray = [];
			$childArray = [];
			$commonArray = [];
			$smallArray = [];
			$kitchenArray = [];
			$allocateArray = [];
			$allocateComArray = [];
			if ( $request->type == 'Commercial' ) {
				foreach ( $request->floor_Type as $fkey => $floorDetails ) {
					$toiletArray[] = [
						'project_id'    => $project->id,
						'floor_Type'    => $request->floor_Type[$fkey],
						'floor_no'      => $request->floor_no[$fkey],
						'location_type' => 'Toilet',
						'fc_quantity'   => $request->commercial_toilet[$fkey],
						'type'          => 'Commercial',
						'created_at'    => now(),
					];
					$basinArr[] = [
						'project_id'    => $project->id,
						'floor_Type'    => $request->floor_Type[$fkey],
						'floor_no'      => $request->floor_no[$fkey],
						'location_type' => 'Wash Basin',
						'fc_quantity'   => $request->basin[$fkey],
						'type'          => 'Commercial',
						'created_at'    => now(),
					];
					$urinalArr[] = [
						'project_id'    => $project->id,
						'floor_Type'    => $request->floor_Type[$fkey],
						'floor_no'      => $request->floor_no[$fkey],
						'location_type' => 'Urinal',
						'fc_quantity'   => $request->urinal[$fkey],
						'type'          => 'Commercial',
						'created_at'    => now(),
					];
					$pantryArr[] = [
						'project_id'    => $project->id,
						'floor_Type'    => $request->floor_Type[$fkey],
						'floor_no'      => $request->floor_no[$fkey],
						'location_type' => 'Pantry',
						'fc_quantity'   => $request->pantry[$fkey],
						'type'          => 'Commercial',
						'created_at'    => now(),
					];
					$CCToiletArr[] = [
						'project_id'    => $project->id,
						'floor_Type'    => $request->floor_Type[$fkey],
						'floor_no'      => $request->floor_no[$fkey],
						'location_type' => 'Common Toilet',
						'fc_quantity'   => $request->common_toilet[$fkey],
						'type'          => 'Commercial',
						'created_at'    => now(),
					];
				}
				foreach ( $request->material_id as $cakey => $alloates ) {
					$allocateComArray[] = [
						'material_id'       => $request->material_id[$cakey] ?? 0,
						'project_id'        => $project->id,
						'commercial_toilet' => $request->allocate_toilet[$cakey] ?? 0,
						'basin'             => $request->allocate_basin[$cakey] ?? 0,
						'urinal'            => $request->allocate_urinal[$cakey] ?? 0,
						'pantry'            => $request->allocate_pantry[$cakey] ?? 0,
						'common_toilet'     => $request->allocate_commonToilet[$cakey] ?? 0,
						'total'             => $request->total[$cakey] ?? 0,
						'type'              => 'Commercial',
					];
				}
			} else {
				foreach ( $request->apartment_type as $key => $detail ) {
					$masterArray[] = [
						'project_id'     => $project->id,
						'apartment_type' => $request->apartment_type[$key],
						'location_type'  => $request->master,
						'owner_quantity' => $request->master_LW[$key],
						'fc_quantity'    => $request->master_FC[$key],
						'type'           => 'Residential',
						'created_at'     => now(),
					];
					$childArray[] = [
						'project_id'     => $project->id,
						'apartment_type' => $request->apartment_type[$key],
						'location_type'  => $request->child,
						'owner_quantity' => $request->child_LW[$key],
						'fc_quantity'    => $request->child_FC[$key],
						'type'           => 'Residential',
						'created_at'     => now(),
					];
					$commonArray[] = [
						'project_id'     => $project->id,
						'apartment_type' => $request->apartment_type[$key],
						'location_type'  => $request->common,
						'owner_quantity' => $request->common_LW[$key],
						'fc_quantity'    => $request->common_FC[$key],
						'type'           => 'Residential',
						'created_at'     => now(),
					];
					$smallArray[] = [
						'project_id'     => $project->id,
						'apartment_type' => $request->apartment_type[$key],
						'location_type'  => $request->smalltoilet,
						'owner_quantity' => $request->smalltoilet_LW[$key],
						'fc_quantity'    => $request->smalltoilet_FC[$key],
						'type'           => 'Residential',
						'created_at'     => now(),
					];
					$kitchenArray[] = [
						'project_id'     => $project->id,
						'apartment_type' => $request->apartment_type[$key],
						'location_type'  => $request->kitchen,
						'owner_quantity' => $request->kitchen_LW[$key],
						'fc_quantity'    => $request->kitchen_FC[$key],
						'type'           => 'Residential',
						'created_at'     => now(),
					];
				}

				foreach ( $request->material_id as $akey => $alloates ) {
					$allocateArray[] = [
						'material_id'     => $request->material_id[$akey] ?? 0,
						'project_id'      => $project->id,
						'master'          => $request->allocate_fc_master[$akey] ?? 0 + $request->allocate_lw_master[$akey] ?? 0,
						'master_fc'       => $request->allocate_fc_master[$akey] ?? 0,
						'master_lw'       => $request->allocate_lw_master[$akey] ?? 0,
						'child'           => $request->allocate_fc_child[$akey] ?? 0 + $request->allocate_lw_child[$akey] ?? 0,
						'child_fc'        => $request->allocate_fc_child[$akey] ?? 0,
						'child_lw'        => $request->allocate_lw_child[$akey] ?? 0,
						'common'          => $request->allocate_fc_commonBath[$akey] ?? 0 + $request->allocate_lw_commonBath[$akey] ?? 0,
						'common_fc'       => $request->allocate_fc_commonBath[$akey] ?? 0,
						'common_lw'       => $request->allocate_lw_commonBath[$akey] ?? 0,
						'small_toilet'    => $request->allocate_fc_smallToilet[$akey] ?? 0 + $request->allocate_lw_smallToilet[$akey] ?? 0,
						'small_toilet_fc' => $request->allocate_fc_smallToilet[$akey] ?? 0,
						'small_toilet_lw' => $request->allocate_lw_smallToilet[$akey] ?? 0,
						'kitchen'         => $request->allocate_fc_kitchen[$akey] ?? 0 + $request->allocate_lw_kitchen[$akey] ?? 0,
						'kitchen_fc'      => $request->allocate_fc_kitchen[$akey] ?? 0,
						'kitchen_lw'      => $request->allocate_lw_kitchen[$akey] ?? 0,
						'total'           => $request->total[$akey] ?? 0,
						'type'            => 'Residential',
						'commonArea'      => $request->common_area[$akey] ?? 0,
					];
				}
			}

			//            dd($request->type, $project->SanitaryAllocationCommertial()->exists());
			if ( $request->type == 'Residential' && $project->SanitaryAllocation()->exists() ) {
				return redirect()->route( 'boq.project.departments.sanitary.sanitary-allocations.index', $project )
					->with( 'error', 'Data already exists for this Project' );
			} elseif ( $request->type == 'Commercial' && $project->SanitaryAllocationCommertial()->exists() ) {
				return redirect()->route( 'boq.project.departments.sanitary.sanitary-allocations.index', $project )
					->with( 'error', 'Data already exists for this Project' );
			} else {
				DB::transaction( function () use (
					$project,
					$request,
					$allocateComArray,
					$toiletArray,
					$basinArr,
					$urinalArr,
					$pantryArr,
					$CCToiletArr,
					$masterArray,
					$childArray,
					$commonArray,
					$smallArray,
					$kitchenArray,
					$allocateArray,
				) {
					if ( $request->type == 'Commercial' ) {
						SanitaryAllocation::insert( $toiletArray );
						SanitaryAllocation::insert( $basinArr );
						SanitaryAllocation::insert( $urinalArr );
						SanitaryAllocation::insert( $pantryArr );
						SanitaryAllocation::insert( $CCToiletArr );
						SanitaryMaterialAllocation::insert( $allocateComArray );
					} else {
						SanitaryAllocation::insert( $masterArray );
						SanitaryAllocation::insert( $childArray );
						SanitaryAllocation::insert( $commonArray );
						SanitaryAllocation::insert( $smallArray );
						SanitaryAllocation::insert( $kitchenArray );
						SanitaryMaterialAllocation::insert( $allocateArray );
					}
				} );
				return redirect()->route( 'boq.project.departments.sanitary.sanitary-allocations.index', $project )->with( 'message', 'Data has been inserted successfully' );
			}
		} catch ( QueryException $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}
	}

	public function show( Project $project, $type = null ) {
		if ( $type == 'Residential' ) {
			$allocations = SanitaryAllocation::with( 'apartmentType' )->residential()->where( 'project_id', $project->id )->get()->groupBy( ['apartment_type', 'location_type'] );
			$sanitaryAllocations = SanitaryMaterialAllocation::with( 'materials' )->where( 'type', 'Residential' )->where( 'project_id', $project->id )->get();
			$type = 'Residential';
			return view( 'boq.departments.sanitary.sanitary-allocations.residential_view', compact( 'project', 'allocations', 'type', 'sanitaryAllocations' ) );
		} else {
			$allocationsCommercial = SanitaryAllocation::commercial()->where( 'project_id', $project->id )->get()
				->groupBy( ['floor_Type'] )
			//            ->groupBy(['floor_Type', 'location_type']);
				->map( function ( $item, $key ) {
					$first = $item->first();
					$commercialData['floor'] = $key;
					$commercialData['floor_no'] = $first->floor_no;
					$commercialData['typeWiseQuantity'] = $item->groupBy( 'location_type' )->flatten()->toArray();
					return $commercialData;
				} );
			$sanitaryAllocations = SanitaryMaterialAllocation::with( 'materials' )->where( 'type', 'Commercial' )->where( 'project_id', $project->id )->get();
			$type = 'Commercial';
			return view( 'boq.departments.sanitary.sanitary-allocations.commercial_view', compact( 'project', 'allocationsCommercial', 'type', 'sanitaryAllocations' ) );
		}
	}

	public function sanitaryAllocationEdit( Project $project, $type = null ) {
		if ( $type == 'Residential' ) {
			$allocations = SanitaryAllocation::with( 'apartmentType' )->residential()->where( 'project_id', $project->id )->get()->groupBy( ['apartment_type', 'location_type'] );
			$sanitaryAllocations = SanitaryMaterialAllocation::with( 'materials' )->where( 'type', 'Residential' )->where( 'project_id', $project->id )->get();
			$type = 'Residential';
			$types = SanitaryLocationType::where( 'type', 1 )->get();
			$formulaData = SanitaryFormulaDetail::with( 'material', 'sanitaryFormula' )
				->whereHas( 'sanitaryFormula', function ( $q ) {
					$q->where( 'location_for', 1 );
				} )->get();
			$formulas = $formulaData->groupBy( ['material_id', 'sanitaryFormula.location_type'] );
			return view( 'boq.departments.sanitary.sanitary-allocations.residentialEdit', compact( 'project', 'allocations', 'type', 'sanitaryAllocations', 'types', 'formulas', 'formulaData' ) );
		} else {
			$allocationsCommercial = SanitaryAllocation::commercial()->where( 'project_id', $project->id )->get()
				->groupBy( ['floor_Type'] )
			//            ->groupBy(['floor_Type', 'location_type']);
				->map( function ( $item, $key ) {
					$first = $item->first();
					$commercialData['floor'] = $key;
					$commercialData['floor_no'] = $first->floor_no;
					$commercialData['typeWiseQuantity'] = $item->groupBy( 'location_type' )->flatten()->toArray();
					return $commercialData;
				} );
			$sanitaryAllocations = SanitaryMaterialAllocation::with( 'materials' )->where( 'type', 'Commercial' )->where( 'project_id', $project->id )->get();
			$type = 'Commercial';
			$types = SanitaryLocationType::where( 'type', 0 )->get();
			$formulaData = SanitaryFormulaDetail::with( 'material', 'sanitaryFormula' )
				->whereHas( 'sanitaryFormula', function ( $q ) {
					$q->where( 'location_for', 0 );
				} )->get();
			$formulas = $formulaData->groupBy( ['material_id', 'sanitaryFormula.location_type'] );
			return view( 'boq.departments.sanitary.sanitary-allocations.commercialEdit', compact( 'project', 'allocationsCommercial', 'type', 'sanitaryAllocations', 'types', 'formulas', 'formulaData' ) );
		}
	}

	public function edit( SanitaryAllocation $sanitaryAllocation, Project $project ) {
		dd( 'sdf' );
		$allocations = SanitaryAllocation::where( 'project_id', $project->id )->get()->groupBy( 'location_type' );
		dd( $allocations );
		return view( 'boq.departments.sanitary.sanitary-allocations.create', compact( 'project', 'sanitaryAllocation' ) );
	}

	public function update( Request $request, SanitaryAllocation $sanitaryAllocation ) {
		SanitaryAllocation::where( 'project_id', $request->project_id )->where( 'type', $request->type )->delete();
		SanitaryMaterialAllocation::where( 'project_id', $request->project_id )->where( 'type', $request->type )->delete();

		$toiletArray = [];
		$basinArr = [];
		$urinalArr = [];
		$pantryArr = [];
		$CCToiletArr = [];
		$masterArray = [];
		$childArray = [];
		$commonArray = [];
		$smallArray = [];
		$kitchenArray = [];
		$allocateArray = [];
		$allocateComArray = [];
		if ( $request->type == 'Commercial' ) {
			foreach ( $request->floor as $fkey => $floorDetails ) {
				$toiletArray[] = [
					'project_id'    => $request->project_id,
					'floor_Type'    => $request->floor[$fkey],
					'floor_no'      => $request->floor_no[$fkey],
					'location_type' => 'Toilet',
					'fc_quantity'   => $request->commercial_toilet[$fkey],
					'type'          => 'Commercial',
					'created_at'    => now(),
				];
				$basinArr[] = [
					'project_id'    => $request->project_id,
					'floor_Type'    => $request->floor[$fkey],
					'floor_no'      => $request->floor_no[$fkey],
					'location_type' => 'Wash Basin',
					'fc_quantity'   => $request->basin[$fkey],
					'type'          => 'Commercial',
					'created_at'    => now(),
				];
				$urinalArr[] = [
					'project_id'    => $request->project_id,
					'floor_Type'    => $request->floor[$fkey],
					'floor_no'      => $request->floor_no[$fkey],
					'location_type' => 'Urinal',
					'fc_quantity'   => $request->urinal[$fkey],
					'type'          => 'Commercial',
					'created_at'    => now(),
				];
				$pantryArr[] = [
					'project_id'    => $request->project_id,
					'floor_Type'    => $request->floor[$fkey],
					'floor_no'      => $request->floor_no[$fkey],
					'location_type' => 'Pantry',
					'fc_quantity'   => $request->pantry[$fkey],
					'type'          => 'Commercial',
					'created_at'    => now(),
				];
				$CCToiletArr[] = [
					'project_id'    => $request->project_id,
					'floor_Type'    => $request->floor[$fkey],
					'floor_no'      => $request->floor_no[$fkey],
					'location_type' => 'Common Toilet',
					'fc_quantity'   => $request->common_toilet[$fkey],
					'type'          => 'Commercial',
					'created_at'    => now(),
				];
			}
			foreach ( $request->material_id as $cakey => $alloates ) {
				$allocateComArray[] = [
					'material_id'       => $request->material_id[$cakey] ?? 0,
					'project_id'        => $request->project_id,
					'commercial_toilet' => $request->allocate_toilet[$cakey] ?? 0,
					'basin'             => $request->allocate_basin[$cakey] ?? 0,
					'urinal'            => $request->allocate_urinal[$cakey] ?? 0,
					'pantry'            => $request->allocate_pantry[$cakey] ?? 0,
					'common_toilet'     => $request->allocate_commonToilet[$cakey] ?? 0,
					'total'             => $request->total[$cakey] ?? 0,
					'type'              => 'Commercial',
				];
			}
		} else {
			foreach ( $request->apartment_type as $key => $detail ) {
				// dd($request->all());
				$masterArray[] = [
					'project_id'     => $request->project_id,
					'apartment_type' => $request->apartment_type[$key],
					'location_type'  => $request->master,
					'owner_quantity' => $request->master_LW[$key],
					'fc_quantity'    => $request->master_FC[$key],
					'type'           => 'Residential',
					'created_at'     => now(),
				];

				$childArray[] = [
					'project_id'     => $request->project_id,
					'apartment_type' => $request->apartment_type[$key],
					'location_type'  => $request->child,
					'owner_quantity' => $request->child_LW[$key],
					'fc_quantity'    => $request->child_FC[$key],
					'type'           => 'Residential',
					'created_at'     => now(),
				];
				$commonArray[] = [
					'project_id'     => $request->project_id,
					'apartment_type' => $request->apartment_type[$key],
					'location_type'  => $request->common,
					'owner_quantity' => $request->common_LW[$key],
					'fc_quantity'    => $request->common_FC[$key],
					'type'           => 'Residential',
					'created_at'     => now(),
				];
				$smallArray[] = [
					'project_id'     => $request->project_id,
					'apartment_type' => $request->apartment_type[$key],
					'location_type'  => $request->smalltoilet,
					'owner_quantity' => $request->smalltoilet_LW[$key],
					'fc_quantity'    => $request->smalltoilet_FC[$key],
					'type'           => 'Residential',
					'created_at'     => now(),
				];
				$kitchenArray[] = [
					'project_id'     => $request->project_id,
					'apartment_type' => $request->apartment_type[$key],
					'location_type'  => $request->kitchen,
					'owner_quantity' => $request->kitchen_LW[$key],
					'fc_quantity'    => $request->kitchen_FC[$key],
					'type'           => 'Residential',
					'created_at'     => now(),
				];
			}

			foreach ( $request->material_id as $akey => $alloates ) {
				$allocateArray[] = [
					'material_id'     => $request->material_id[$akey] ?? 0,
					'project_id'      => $request->project_id,
					'master'          => $request->allocate_fc_master[$akey] ?? 0 + $request->allocate_lw_master[$akey] ?? 0,
					'master_fc'       => $request->allocate_fc_master[$akey] ?? 0,
					'master_lw'       => $request->allocate_lw_master[$akey] ?? 0,
					'child'           => $request->allocate_fc_child[$akey] ?? 0 + $request->allocate_lw_child[$akey] ?? 0,
					'child_fc'        => $request->allocate_fc_child[$akey] ?? 0,
					'child_lw'        => $request->allocate_lw_child[$akey] ?? 0,
					'common'          => $request->allocate_fc_commonBath[$akey] ?? 0 + $request->allocate_lw_commonBath[$akey] ?? 0,
					'common_fc'       => $request->allocate_fc_commonBath[$akey] ?? 0,
					'common_lw'       => $request->allocate_lw_commonBath[$akey] ?? 0,
					'small_toilet'    => $request->allocate_fc_smallToilet[$akey] ?? 0 + $request->allocate_lw_smallToilet[$akey] ?? 0,
					'small_toilet_fc' => $request->allocate_fc_smallToilet[$akey] ?? 0,
					'small_toilet_lw' => $request->allocate_lw_smallToilet[$akey] ?? 0,
					'kitchen'         => $request->allocate_fc_kitchen[$akey] ?? 0 + $request->allocate_lw_kitchen[$akey] ?? 0,
					'kitchen_fc'      => $request->allocate_fc_kitchen[$akey] ?? 0,
					'kitchen_lw'      => $request->allocate_lw_kitchen[$akey] ?? 0,
					'total'           => $request->total[$akey] ?? 0,
					'type'            => 'Residential',
					'commonArea'      => $request->common_area[$akey] ?? 0,
				];
			}
		}

		$project = Project::find( $request->project_id );

		DB::transaction( function () use (
			$project,
			$request,
			$allocateComArray,
			$toiletArray,
			$basinArr,
			$urinalArr,
			$pantryArr,
			$CCToiletArr,
			$masterArray,
			$childArray,
			$commonArray,
			$smallArray,
			$kitchenArray,
			$allocateArray,
		) {
			if ( $request->type == 'Commercial' ) {
				SanitaryAllocation::insert( $toiletArray );
				SanitaryAllocation::insert( $basinArr );
				SanitaryAllocation::insert( $urinalArr );
				SanitaryAllocation::insert( $pantryArr );
				SanitaryAllocation::insert( $CCToiletArr );
				SanitaryMaterialAllocation::insert( $allocateComArray );
			} else {
				SanitaryAllocation::insert( $masterArray );
				SanitaryAllocation::insert( $childArray );
				SanitaryAllocation::insert( $commonArray );
				SanitaryAllocation::insert( $smallArray );
				SanitaryAllocation::insert( $kitchenArray );
				SanitaryMaterialAllocation::insert( $allocateArray );
			}
		} );
		$project = Project::find( $request->project_id );
		return redirect()->route( 'boq.project.departments.sanitary.sanitary-allocations.index', $project->id )->with( 'message', 'Data has been inserted successfully' );
	}

	public function destroy( SanitaryAllocation $sanitaryAllocation ) {
		dd( 'sdfs' );
	}
}
