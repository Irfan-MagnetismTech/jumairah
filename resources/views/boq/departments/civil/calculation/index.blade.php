@extends('boq.calculation.layout.app', ['sidebar_boq_areas' => $sidebar_boq_areas])
@section('title', 'BOQ - Calculations')
@section('project-name')
    <a href="{{ route('boq.project.departments.civil.materials.calculations.index', ['project' => $project]) }}" style="color:white;">{{ $project->name }}</a>
@endsection
@section('breadcrumb-title')
    BOQ Material Calculations
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="3">
                    <h4>Project name - {{ $project->name }}</h4>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3">
                    <h6>Total buildup area - {{ number_format($project->boqAreas()->sum('area'), '2', '.', ',') }} Sft</h6>
                </td>
            </tr>
        </tbody>
    </table>

    <p>Please click on any floor to calculate materials.</p>
@endsection
