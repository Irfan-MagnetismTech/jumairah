<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary\CostAnalysis;

use App\Boq\Departments\Sanitary\ProjectWiseMaterialDetails;
use App\Http\Controllers\Controller;
use App\Project;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class BoqSanitaryCostAnalysisController extends Controller {
    public function materialSummary( Project $project, Request $request ) {

        try
        {

            $total_areas = $project->boqFloorProjects()->sum( 'area' );
            $material_statements = ProjectWiseMaterialDetails::with( 'projectWiseMaterial' )
                ->whereHas( 'projectWiseMaterial', function ( $q ) use ( $project ) {
                    $q->where( 'project_id', $project->id );
                } )
                ->where( 'quantity', '!=', 0 )
                ->groupBy( 'material_id' )
                ->selectRaw( '*, SUM(quantity) as gross_total_quantity' )
                ->with( 'material.unit' )
                ->get();

            // dd( $material_statements );

            $material_statements = $material_statements->sortBy( 'material.name' );

            $material_list = $material_statements;

            // $material_statements if request nested_material_id is not null
            if ( $request->nested_material_id ) {
                $material_statements = $material_statements->where( 'material_id', $request->nested_material_id );
            }

            $floor_wise_group = $material_statements->map( function ( $material ) use ( $project ) {
                $floors = ProjectWiseMaterialDetails::
                    whereHas( 'projectWiseMaterial', function ( $q ) use ( $project ) {
                    $q->where( 'project_id', $project->id );
                } )
                    ->where( 'material_id', $material->material_id )
                    ->where( 'quantity', '>', 0 )
                    ->with( 'projectWiseMaterial.floorProject.boqCommonFloor' )
                    ->selectRaw( '*, SUM(quantity) as gross_total_quantity' )
                    ->get();

                return [
                    'material_id'    => $material?->material?->id,
                    'material_name'  => $material?->material?->name,
                    'material_unit'  => $material?->material?->unit?->name,
                    'floors'         => $floors,
                    'total_quantity' => $floors->sum( 'gross_total_quantity' ),
                ];
            } );

            $material_statements = collect( $floor_wise_group )->sortBy( 'floor_id' )->values()->all();

            //return response()->json($material_statements);

            return view( 'boq.departments.sanitary.costanalysis.summary-sheet', compact( 'project', 'total_areas', 'material_statements', 'material_list' ) );
        } catch ( \Exception $e ) {
            return redirect()->back()->withError( $e->getMessage() );
        }
    }

    public function downloadMaterialSummary( Project $project, Request $request ) {

        try
        {
            $total_areas = $project->boqFloorProjects()->sum( 'area' );
            $material_statements = ProjectWiseMaterialDetails::with( 'projectWiseMaterial' )
                ->whereHas( 'projectWiseMaterial', function ( $q ) use ( $project ) {
                    $q->where( 'project_id', $project->id );
                } )
                ->where( 'quantity', '!=', 0 )
                ->groupBy( 'material_id' )
                ->selectRaw( '*, SUM(quantity) as gross_total_quantity' )
                ->with( 'material.unit' )
                ->get();

            $material_statements = $material_statements->sortBy( 'material.name' );

            $material_list = $material_statements;

            // $material_statements if request nested_material_id is not null
            if ( $request->nested_material_id ) {
                $material_statements = $material_statements->where( 'material_id', $request->nested_material_id );
            }

            $floor_wise_group = $material_statements->map( function ( $material ) use ( $project ) {
                $floors = ProjectWiseMaterialDetails::
                    whereHas( 'projectWiseMaterial', function ( $q ) use ( $project ) {
                    $q->where( 'project_id', $project->id );
                } )
                    ->where( 'material_id', $material->material_id )
                    ->where( 'quantity', '>', 0 )
                    ->with( 'projectWiseMaterial.floorProject.boqCommonFloor' )
                    ->selectRaw( '*, SUM(quantity) as gross_total_quantity' )
                    ->get();

                return [
                    'material_id'    => $material?->material?->id,
                    'material_name'  => $material?->material?->name,
                    'material_unit'  => $material?->material?->unit?->name,
                    'floors'         => $floors,
                    'total_quantity' => $floors->sum( 'gross_total_quantity' ),
                ];
            } );

            $material_statements = collect( $floor_wise_group )->sortBy( 'floor_id' )->values()->all();

            $pdf = new PDF();
            return PDF::loadview( 'boq.departments.sanitary.costanalysis.summary-sheet-pdf', compact(
                'project',
                'total_areas', 'material_statements', 'pdf', 'material_list'
            ) )->stream( 'ms-rod.pdf' );

            //return response()->json($material_statements);

            return view( 'boq.departments.sanitary.costanalysis.summary-sheet', compact( 'project', 'total_areas', 'material_statements', 'material_list' ) );
        } catch ( \Exception $e ) {
            return redirect()->back()->withError( $e->getMessage() );
        }
    }
}
