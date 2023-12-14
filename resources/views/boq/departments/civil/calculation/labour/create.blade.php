@extends('boq.calculation.layout.app', ['sidebar_boq_areas' => $sidebar_boq_areas])
@section('title', 'BOQ - Labour Calculations')
@section('project-name')
    <a href="{{ route('boq.project.departments.civil.labours.calculations.index', ['project' => $project]) }}" style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    {{ $boq_area->boqCommonFloor->name }} - Labour Calculations
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
    <div class="float-right">
        <a href="{{ route('boq.project.departments.civil.labours.floorwise.data', ['project' => $project, 'boq_area' => $boq_area]) }}" class="btn btn-out-dashed btn-sm btn-warning">
            <i class="fas fa-database"></i>
        </a>
    </div>
@endsection

@section('content')
    <form action="{{ route('boq.project.departments.civil.labours.calculations.store', ['project' => $project, 'boq_area' => $boq_area]) }}" method="POST" enctype="multipart/form-data" class="custom-form">
        @include('boq.calculation.labour.form')
        @include('components.buttons.submit-button', ['label' => 'Save'])
    </form>
@endsection
