@extends('boq.calculation.layout.app', ['sidebar_boq_areas' => $sidebar_boq_areas])
@section('title', 'BOQ - Calculations')
@section('project-name')
    {{-- <a href="{{ route('boq.project.calculations.index', ['project' => $project]) }}" style="color:white;">{{ $project->name }}</a> --}}
@endsection

@section('breadcrumb-title')
    {{ $boq_area->boqCommonFloor->name }} - Reinforcement Calculations
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
    <div class="float-right">
        <a href="{{ route('boq.project.reinforcement.floorwise.calculation.data', ['project' => $project, 'boq_area' => $boq_area]) }}" class="btn btn-out-dashed btn-sm btn-warning">
            <i class="fas fa-database"></i>
        </a>
    </div>
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ route('boq.project.reinforcement.calculations.store', ['project' => $project, 'boq_area' => $boq_area]) }}" class="btn btn-out-dashed btn-sm btn-warning">
    <i class="fas fa-database"></i>
</a> --}}
@endsection

{{-- @section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3') --}}

@section('content')
    <form action="{{ route('boq.project.reinforcement.calculations.store', ['project' => $project, 'boq_area' => $boq_area]) }}" method="POST" enctype="multipart/form-data" class="custom-form">
        @include('boq.calculation.reinforcement.form')
        @include('components.buttons.submit-button', ['label' => 'Save'])
    </form>
@endsection
