@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Edit reinforcement measurement')

@section('breadcrumb-title')
    Edit Reinforcement Measurement
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.configurations.reinforcement-measurement.index', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <!-- Form -->
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.civil.configurations.reinforcement-measurement.update', ['project' => $project,'reinforcementMeasurement' => $reinforcementMeasurement]) }}" method="POST" class="custom-form">
                @method('PUT')
                @include('boq.departments.civil.configurations.reinforcement-measurement.form')
                @include('components.buttons.submit-button', ['label' => 'Update Measurement'])
            </form>
        </div>
    </div>
@endsection
