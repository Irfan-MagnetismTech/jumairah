<?php

namespace App\Http\Controllers\Boq\Departments\Electrical\CostAnalysis;

use App\Http\Controllers\Controller;
use App\Project;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BoqElectricalCostAnalysisController extends Controller {

    public function materialSummary( Project $project, Request $request ) {

        try
        {
            $total_areas = $project->boqFloorProjects()->sum( 'area' );
            $material_statements = $project->boqEmeCalculation()
            // ->where('budget_type','!=','labour')
                ->where( 'quantity', '!=', 0 )
                ->groupBy( 'material_id' )
                ->selectRaw( '*, SUM(quantity) as gross_total_quantity' )
                ->with( 'nestedMaterial.unit' )
                ->get();

            $material_statements = $material_statements->sortBy( 'nestedMaterial.name' );

            $material_list = $material_statements;

            // $material_statements if request nested_material_id is not null
            if ( $request->nested_material_id ) {
                $material_statements = $material_statements->where( 'material_id', $request->nested_material_id );
            }

            $floor_wise_group = $material_statements->map( function ( $material ) use ( $project ) {
                $floors = $project->boqEmeCalculation()
                    ->where( 'material_id', $material->material_id )
                    ->where( 'quantity', '>', 0 )
                    ->groupBy( 'floor_id' )
                    ->selectRaw( '*, SUM(quantity) as gross_total_quantity' )
                    ->with( 'BoqFloorProject.boqCommonFloor' )
                    ->get();

                return [
                    'material_id'    => $material?->nestedMaterial?->id,
                    'material_name'  => $material?->nestedMaterial?->name,
                    'material_unit'  => $material?->nestedMaterial?->unit?->name,
                    'floors'         => $floors,
                    'total_quantity' => $floors->sum( 'gross_total_quantity' ),
                ];
            } );
            $material_statements = collect( $floor_wise_group )->sortBy( 'floor_id' )->values()->all();

            // return response()->json($material_statements);

            return view( 'boq.departments.electrical.costanalysis.summary-sheet', compact( 'project', 'total_areas', 'material_statements', 'material_list' ) );
        } catch ( QueryException $e ) {
            return redirect()->back()->withError( $e->getMessage() );
        }
    }

    public function downloadMaterialSummary( Project $project, Request $request ) {

        try
        {
            $total_areas = $project->boqFloorProjects()->sum( 'area' );
            $material_statements = $project->boqEmeCalculation()
            // ->where('budget_type','!=','labour')
                ->where( 'quantity', '!=', 0 )
                ->groupBy( 'material_id' )
                ->selectRaw( '*, SUM(quantity) as gross_total_quantity' )
                ->with( 'nestedMaterial.unit' )
                ->get();

            $material_statements = $material_statements->sortBy( 'nestedMaterial.name' );

            $material_list = $material_statements;

            // $material_statements if request nested_material_id is not null
            if ( $request->nested_material_id ) {
                $material_statements = $material_statements->where( 'material_id', $request->nested_material_id );
            }

            $floor_wise_group = $material_statements->map( function ( $material ) use ( $project ) {
                $floors = $project->boqEmeCalculation()
                    ->where( 'material_id', $material->material_id )
                    ->where( 'quantity', '>', 0 )
                    ->groupBy( 'floor_id' )
                    ->selectRaw( '*, SUM(quantity) as gross_total_quantity' )
                    ->with( 'BoqFloorProject.boqCommonFloor' )
                    ->get();

                return [
                    'material_id'    => $material?->nestedMaterial?->id,
                    'material_name'  => $material?->nestedMaterial?->name,
                    'material_unit'  => $material?->nestedMaterial?->unit?->name,
                    'floors'         => $floors,
                    'total_quantity' => $floors->sum( 'gross_total_quantity' ),
                ];
            } );

            $material_statements = collect( $floor_wise_group )->sortBy( 'floor_id' )->values()->all();

            $pdf = new PDF();
            return PDF::loadview( 'boq.departments.electrical.costanalysis.summary-sheet-pdf', compact(
                'project',
                'total_areas', 'material_statements', 'pdf', 'material_list'
            ) )->stream( 'ms-rod.pdf' );

            //return response()->json($material_statements);

            return view( 'boq.departments.electrical.costanalysis.summary-sheet', compact( 'project', 'total_areas', 'material_statements', 'material_list' ) );
        } catch ( \Exception $e ) {
            return redirect()->back()->withError( $e->getMessage() );
        }
    }
}
