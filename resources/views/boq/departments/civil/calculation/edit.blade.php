@extends('boq.departments.civil.layout.app')
@section('project-name', $project->name)
@section('title', 'BOQ - Civil Home')

@section('breadcrumb-button')
    <div class="float-right">
        <a href="{{ route('boq.project.departments.civil.calculations.index', ['project' => $project, 'calculation_type' => $calculation_type]) }}" class="btn btn-out-dashed btn-sm btn-warning">
            <i class="fas fa-database"></i>
        </a>
    </div>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    <form action="{{ route('boq.project.departments.civil.calculations.update', ['project' => $project, 'calculation_type' => $calculation_type, 'calculation' => $calculation]) }}" method="POST" enctype="multipart/form-data" class="custom-form">
        @method('PUT')
        @include('boq.departments.civil.calculation.edit-form')
        @include('components.buttons.submit-button', ['label' => 'Update'])
    </form>
@endsection
