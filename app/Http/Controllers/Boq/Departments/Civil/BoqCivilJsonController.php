<?php

namespace App\Http\Controllers\Boq\Departments\Civil;

use App\Boq\Configurations\BoqFloorType;
use App\Boq\Configurations\BoqMaterialPriceWastage;
use App\Boq\Configurations\BoqWork;
use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Boq\Departments\Civil\BoqCivilCalc;
use App\Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheet;
use App\Boq\Departments\Eme\BoqEmeCs;
use App\Boq\Departments\Eme\BoqEmeCsSupplier;
use App\Boq\Departments\Eme\BoqEmeRate;
use App\Boq\Departments\Eme\BoqEmeUtilityBill;
use App\Boq\Departments\Sanitary\SanitaryMaterialAllocation;
use App\Boq\Projects\BoqFloorProject;
use App\Http\Controllers\Controller;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\NestedMaterial;
use App\Procurement\Requisitiondetails;
use App\Procurement\Unit;
use App\Project;
use App\Sells\Apartment;
use App\Sells\Client;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BoqCivilJsonController extends Controller {
    private const FLOOR_INDEX = 3;
    /**
     * Get floors by floor type.
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFloorByType( Request $request, Project $project ): JsonResponse {
        try {
            $floor_type = $request->get( 'floor_type' );
            $flr_type_qry = fn( $query ) => $query->where( 'id', $floor_type );

            $mp = fn( $item ) => ['id' => $item->boq_floor_project_id, 'name' => $item?->floor?->name];

            $boq_floors = $project->boqFloorProjects()
                ->with( 'floor' )
                ->whereHas( 'floor.floor_type', $flr_type_qry )
                ->get()
                ->map( $mp );

            $boq_floors->sortBy( 'name' );

            return response()->json( $boq_floors );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()] );
        }

    }

    /**
     * Get Boq Calculation Details for Copy
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFloorForCopy( Request $request, Project $project ): JsonResponse {
        try {
            $except_floor_id = explode( '-', $request->get( 'floor_id' ) )[self::FLOOR_INDEX] ?? null;

            $ft_query = fn( $query ) => $query->where( 'id', '!=', $except_floor_id );
            $mp = fn( $item ) => ['id' => $item->boq_floor_id, 'name' => $item->boqCivilCalcProjectFloor->floor->name];

            $calcs = BoqCivilCalc::with( 'boqCivilCalcProjectFloor.floor' )
                ->whereHas( 'boqCivilCalcProjectFloor.floor', $ft_query )
                ->where( 'project_id', $project->id )
                ->where( 'work_id', $request->work_id )
                ->get()
                ->map( $mp );

            return response()->json( $calcs, 200 );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    /**
     * @param Request $request
     */
    public function getWorkByLocationType( Request $request ): JsonResponse {
        try {
            $works = BoqFloorType::find( $request->get( 'floor_type' ) )->boqWorks()
            // where boq works parent id is null
                ->where( 'calculation_type', $request->get( 'calculation_type' ) )

                ->get();
            //$works = BoqFloorType::find($request->get('floor_type'))->boqFilteredWorks()->get();

            return response()->json( $works, 200 );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    /**
     * @param Request $request
     */
    public function getUnits( Request $request ): JsonResponse {
        try {
            $units = Unit::all()->except( $request->get( 'except_unit_id' ) );

            return response()->json( $units, 200 );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    public function getConsumableMaterialByHead( Request $request, Project $project ): JsonResponse {

        try {

            $materials = BoqMaterialPriceWastage::where( 'other_material_head', htmlspecialchars_decode( $request->other_material_head ) )
                ->with( 'material.unit' )
                ->get();

            $boqCivilBudgetMaterials = BoqCivilBudget::where( 'project_id', $project->id )
                ->where( 'budget_type', 'other' )
                ->where( 'cost_head', htmlspecialchars_decode( $request->other_material_head ) )
                ->with( 'boqMaterialPriceWastage.material.unit' )
                ->get();

            $consumableCost = [];
            $boqCivilConsumableCost = [];

            foreach ( $boqCivilBudgetMaterials as $boqCivilBudgetMaterial ) {
                $boqCivilConsumableCost[] = [
                    'id'                  => $boqCivilBudgetMaterial->id,
                    'nested_material_id'  => $boqCivilBudgetMaterial->nested_material_id,
                    'project_id'          => $boqCivilBudgetMaterial->project_id,
                    'price'               => $boqCivilBudgetMaterial->rate,
                    'wastage'             => $boqCivilBudgetMaterial->wastage,
                    'name'                => $boqCivilBudgetMaterial?->boqMaterialPriceWastage?->material?->name,
                    'unit'                => $boqCivilBudgetMaterial?->boqMaterialPriceWastage?->material?->unit?->name,
                    'other_material_head' => $boqCivilBudgetMaterial->cost_head,
                    'other_civil_budget'  => $boqCivilBudgetMaterial,
                ];
            }

            foreach ( $materials as $material ) {
                $consumableCost[] = [
                    'id'                  => $material->id,
                    'nested_material_id'  => $material->nested_material_id,
                    'project_id'          => $material->project_id,
                    'price'               => $material->price,
                    'wastage'             => $material->wastage,
                    'name'                => $material?->material?->name,
                    'unit'                => $material?->material?->unit?->name,
                    'other_material_head' => $material->other_material_head,
                    'other_civil_budget'  => BoqCivilBudget::where( 'project_id', $project->id )
                        ->where( 'nested_material_id', $material->nested_material_id )->where( 'budget_type', 'other' )->first(),
                ];
            }

            //merge two collection and remove duplicate nested_material_id
            $consumableCost = collect( $boqCivilConsumableCost )->merge( collect( $consumableCost ) )->unique( 'nested_material_id' )->values()->all();

            //$consumableCost sort by name
            usort( $consumableCost, function ( $a, $b ) {
                return $a['name'] <=> $b['name'];
            } );

            return response()->json( $consumableCost, 200 );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    public function getConsumableMaterialById( Request $request, Project $project ): JsonResponse {
        try {
            $material = BoqMaterialPriceWastage::where( 'nested_material_id', $request->nested_material_id )
                ->with( 'material.unit' )
                ->first();

            return response()->json( $material, 200 );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    public function getMaterialRevisedBudgetById( Request $request, Project $project ): JsonResponse {
        try {
            //latest material where material id and $request->nested_material_id
//            $material = BoqCivilRevisedSheet::where( 'nested_material_id', $request->nested_material_id )
//                ->where( 'project_id', $project->id )
//                ->with( 'material.unit' )
//                ->latest()
//                ->select( 'quantity' )
//                ->first();
//            $maxNo = BoqCivilRevisedSheet::where('project_id', $project->id)->max('escalation_no');

            $material = BoqCivilRevisedSheet::where('nested_material_id', $request->nested_material_id)
                ->where('project_id', $project->id)
                ->where('escalation_no',$request->escalation_no - 1)
                ->with('material.unit')
                ->first();

//            if($maxNo===0){
//                $material = BoqCivilRevisedSheet::where('nested_material_id', $request->nested_material_id)
//                    ->where('project_id', $project->id)
//                    ->where('escalation_no',$request->)
//                    ->with('material.unit')
//                    ->first();
//            } else {
//                $material = BoqCivilRevisedSheet::where('nested_material_id', $request->nested_material_id)
//                    ->where('project_id', $project->id)
//                    ->where('escalation_no',$maxNo-1)
//                    ->with('material.unit')
//                    ->first();
//            }

//            $material = BoqCivilRevisedSheet::where('nested_material_id', $request->nested_material_id)
//                ->where('project_id', $project->id)
//                ->with('material.unit')
//                ->latest()
//                ->skip(1) // Skip the most recent record (latest) to get the previous one
//                ->first();


//            if ( !$material ) {
//                $material = BoqMaterialPriceWastage::where( 'nested_material_id', $request->nested_material_id )
//                    ->with( 'material.unit' )
//                    ->first();
//            }

            return response()->json( $material, 200 );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    public function getMaterialConversionDataById( Request $request, Project $project ): JsonResponse {
        try {
            $material = BoqSupremeBudget::where( 'material_id', $request->nested_material_id )
                ->where('budget_for', 'Civil')
                ->where( 'project_id', $project->id )
                ->where( 'floor_id', $request->floor_id )
                ->where( 'budget_type', $request->budget_type)
                ->latest()
                ->first();

            return response()->json( $material, 200 );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    public function getMaterialLeftBalanceByDate( Request $request, Project $project ): JsonResponse {
        try {

            $boqFloorProject = BoqFloorProject::where( 'boq_floor_project_id', $request->floor_id )->first();
            $date = Carbon::parse( $request->till_date )->format( 'Y-m-d' );

            if(!empty($boqFloorProject)){
                $totalRequisitionQty = Requisitiondetails::where( 'project_id', $project->id )
                    ->where( 'material_id', $request->material_id )
                    ->where( 'floor_id', $boqFloorProject->floor_id )
                    ->whereDate( 'required_date', '<=', $date )
                    ->sum( 'quantity' );
            } else {
                $totalRequisitionQty = Requisitiondetails::where( 'project_id', $project->id )
                    ->where( 'material_id', $request->material_id )
                    ->where( 'floor_id', $request->floor_id )
                    ->whereDate( 'required_date', '<=', $date )
                    ->sum( 'quantity' );
            }

            $supremeBudget = BoqSupremeBudget::where( 'project_id', $project->id )
                ->where( 'material_id', $request->material_id )
                ->where( 'floor_id', $request->floor_id )
                ->sum( 'quantity' );

            $leftBalance = $supremeBudget - $totalRequisitionQty;

            return response()->json( $leftBalance, 200 );

        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    public function getMaterialCurrentPrice( Request $request, Project $project ): JsonResponse {
        try {

            $material = BoqCivilRevisedSheet::where( 'nested_material_id', $request->material_id )
                ->where( 'project_id', $project->id )
                ->where( 'boq_floor_id', $request->floor_id )
                ->latest()
                ->select( 'price_after_revised' )
                ->first();

            return response()->json( $material, 200 );
        } catch ( \Exception $e ) {
            return response()->json( ['error' => $e->getMessage()], 500 );
        }

    }

    public function getProjectWiseMaterialRate( Project $project ) {
        $parentId = request()->material_first;
        $parentSecondId = request()->material_second;
        // dd(parentId);
        $sanitaryMaterial = NestedMaterial::where( 'id', $parentSecondId )->where( 'account_id', 123 )
            ->with( ['materialAllocation' => function ( $q ) use ( $project ) {
                $q->where( 'project_id', $project->id );
            },
            ] )
            ->with( 'descendants.sanitaryMaterialRates' )
            ->with( ['descendants.materialAllocation' => function ( $q ) use ( $project ) {
                $q->where( 'project_id', $project->id );
            },
            ] )
            ->first();

        $sanitaryMaterial['total_sanitary'] = SanitaryMaterialAllocation::where( 'project_id', $project->id )->where( 'material_id', $parentSecondId )->sum( 'total' );

// dd($sanitaryMaterial);

// $sanitaryMaterial = NestedMaterial::with('sanitaryMaterialRates', 'materialAllocation')

//                 ->whereNotNull('parent_id')

//                 ->where('parent_id', $parentId)

//                 ->where('account_id', 123)

//                 ->get();

//                 dd($sanitaryMaterial->toArray());

//         $parentId = request()->material_first;

//         $parentSecondId = request()->material_second;

//         $parentMaterials = NestedMaterial::whereNull('parent_id')->where('account_id', 123)->where('id',$parentId)->pluck('id', 'id');

//         $nestedMaterial = NestedMaterial::whereIn('parent_id', $parentMaterials)->whereHas('descendants.sanitaryMaterialRates');

//         $nestedMaterialData = $nestedMaterial->with('materialAllocation')->where('id', $parentSecondId)->get();

// //        if (!empty($parentSecondId)){

// //            $nestedMaterialData = $nestedMaterial->where('id', $parentSecondId)->get();

// //        }else{

// //            $nestedMaterialData = $nestedMaterial->get();

// //        }

// //        dd($project->id);

//         $materials = $nestedMaterialData

//             ->filter(function ($item) use ($project){

//                 $materialId  = $item->descendants->flatten()->pluck('id');

//                 $item['sanitaryMaterials'] = SanitaryMaterialRate::

//                     with('material.parent.materialAllocation','material.materialAllocation')

//                     ->whereIn('material_id', $materialId)->get();

//                 return $item;

//             });

        //        dd($materials->toArray());
        return response()->json( $sanitaryMaterial );
    }

    public function getSanitaryMaterial( Request $request ) {
        $search = $request->search;

//        $parent = NestedMaterial::whereNull('parent_id')->orderBy('name')->where('account_id',123)->pluck('id','id');

//        $second = NestedMaterial::whereIn('parent_id',$parent);

//        $secondParent = $second->pluck('id','id');
        //        $secondMaterial = $second->get();
        $materials = NestedMaterial::with( 'unit' )
        //            ->whereIn('parent_id',$parent)
            ->where( 'name', 'like', '%' . $search . '%' )
            ->orderBy( 'id' )
            ->descendantsAndSelf( 998 )
            ->map( fn( $item ) => [
                'label'       => $item->name,
                'material_id' => $item->id,
                'unit_name'   => $item->unit->name,
            ] );
        //        dd($materials);
        return response()->json( $materials );
    }

    /*  ********************** Eme json routes ********************************  */
    public function materialAutoSuggestWhereDepthMorethanThree( Request $request ) {
        $search = $request->search;
        $items = NestedMaterial::where( 'name', 'LIKE', "%$search%" )
            ->withDepth()
            ->having( 'depth', '>=', 2 )
            ->limit( 15 )
            ->get();
        $response = [];

        foreach ( $items as $item ) {
            $response[] = [
                'label'       => $item->name,
                'value'       => $item->name,
                'material_id' => $item->id,
                'unit'        => $item->unit->name,
            ];
        }

        return response()->json( $response );
    }

    public function floorAutoSuggest( $projecy_id, Request $request ) {
        $search = $request->search;
        $response = BoqFloorProject::where( 'project_id', $projecy_id )
            ->whereHas( 'floor', function ( $q ) use ( $search ) {
                $q->where( 'name', 'LIKE', "%$search%" );
            } )
            ->get()
            ->map( fn( $item ) => [
                'label'    => $item->floor->name,
                'floor_id' => $item->floor_id,
            ] );

        return response()->json( $response );
    }

    public function clientAutoSuggest( Request $request ) {
        $search = $request->search;
        $project_id = $request->project_id;
        $client = Client::query()
            ->with( 'sellsClients.sell.apartment' )
            ->where( 'name', 'like', "%$search%" )
            ->whereHas( 'sellsClients', function ( $item ) use ( $project_id ) {
                $item->whereHas( 'sell', function ( $item ) use ( $project_id ) {
                    $item->whereHas( 'apartment', function ( $item ) use ( $project_id ) {
                        $item->where( 'project_id', $project_id );
                    } );
                } );
            } )
            ->get()
            ->map( fn( $item ) => [
                'label' => $item->name,
                'value' => $item->id,
            ] );
        return response()->json( $client );
    }

    public function getApartmentName( Request $request ) {
        $client_id = $request->client_id;
        $project_id = $request->project_id;
        $option_view = '<option value="">Select Apartment Name</option>';
        $apartment = Apartment::query()
            ->where( 'project_id', $project_id )
            ->whereHas( 'sell', function ( $query ) use ( $client_id ) {
                $query->whereHas( 'sellClients', function ( $query1 ) use ( $client_id ) {
                    $query1->where( 'client_id', $client_id );
                } );
            } )->get();

        foreach ( $apartment as $key => $value ) {
            $option_view .= "<option value='$value->id'>$value->name</option>";
        }

        return $option_view;
    }

    public function previousBillPeriod( Request $request ) {
        $apartment_id = $request->apartment_id;
        $project_id = $request->project_id;
        $last_period = BoqEmeUtilityBill::query()
            ->where( ['project_id' => $project_id, 'apartment_id' => $apartment_id] )
            ->get( ['period', 'previous_reading'] )
            ->last();
        return response()->json( $last_period );
    }

    public function materialSuggestWithLaborRate( $project_id, Request $request ) {
        $rates = BoqEmeRate::query()
            ->whereHas( 'NestedMaterial', function ( $item ) use ( $request ) {
                $item->where( 'parent_id', $request->parent_material_id )->where( 'name', 'like', "%$request->search%" );
            } )->get()
            ->map( fn( $item ) => [
                'label' => $item->NestedMaterial->name,
                'value' => $item->material_id,
                'unit'  => $item->NestedMaterial->unit->name,
                'rate'  => $item->labour_rate,
            ] );
        return response()->json( $rates );
    }

    public function workSuggestWithLaborRate( $project_id, Request $request ) {
        $rates = BoqEmeRate::query()
            ->whereHas( 'boqWork', function ( $item ) use ( $request ) {
                $item->where( 'name', 'like', "%$request->search%" )->where( 'parent_id', $request->parent_id );
            } )->get()
            ->map( fn( $item ) => [
                'label' => $item->boqWork->name,
                'value' => $item->boq_work_id,
                'rate'  => $item->labour_rate,
            ] );
        return response()->json( $rates );
    }

    public function boqWorkAutoSuggest( $project_id, Request $request ) {
        $search = $request->search;
        $response = BoqWork::query()
            ->where( 'name', 'LIKE', "%$search%" )
            ->where( 'parent_id', $request->parent_id )
            ->get()
            ->map( fn( $item ) => [
                'label' => $item->name,
                'value' => $item->id,
            ] );

        return response()->json( $response );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getBoqWorksByWorkId( Request $request ) {
        try {
            $boq_works = BoqWork::where( 'id', $request->work_id )
                ->with( ['children'] )
                ->first();

            return $boq_works;
        } catch ( QueryException $e ) {
            return response()->json( $e->getMessage() );
        }

    }

    /**
     * Get sub works by work id.
     *
     * @param Request $request
     * @return mixed
     */
    public function getBoqSubWorksByWorkId( Request $request ) {
        $boq_sub_works = BoqWork::query()
            ->where( 'parent_id', $request->work_id )
            ->whereHas( 'children' )
            ->get();

        return $boq_sub_works;
    }

    public function workCSRefAutoSuggest( Request $request ) {
        $search = $request->search;
        $project_id = $request->project_id;

        if ( $search == '' ) {
            $items = BoqEmeCs::where( 'project_id', $project_id )->limit( 5 )->get( ['reference_no', 'id'] );
        } else {
            $items = BoqEmeCs::where( 'project_id', $project_id )->where( 'reference_no', 'like', '%' . $search . '%' )->limit( 10 )->get();
        }

        $response = array();

        foreach ( $items as $item ) {
            $response[] = [
                "label"      => $item->reference_no,
                "value"      => $item->id,
                "project_id" => $item->project_id,
            ];
        }

        return response()->json( $response );
    }

    public function loadWorkCsSupplier( $cs_id ) {
        return BoqEmeCsSupplier::query()
            ->with( 'supplier:id,name' )
            ->where( 'boq_eme_cs_id', $cs_id )
            ->where( 'is_checked', true )
            ->get( ['id', 'boq_eme_cs_id', 'supplier_id'] );
    }

    public function getDecendentsBasedOnParent( $project_id, Request $request ) {
        $search = $request->search;
        $parent_material_id = $request->parent_material_id;
        info( 'pm' );
        info( $parent_material_id );
        $materials = NestedMaterial::with( 'unit' )
            ->findOrFail( $parent_material_id )
            ->descendants()
            ->where( 'name', 'like', '%' . $search . '%' )
            ->get()
            ->map( fn( $item ) => [
                'label'       => $item->name,
                'material_id' => $item->id,
                'unit_name'   => $item->unit->name,
            ] );
        info( $materials );
        return response()->json( $materials );
    }

    /*  ********************** Eme json routes ********************************  */
}
