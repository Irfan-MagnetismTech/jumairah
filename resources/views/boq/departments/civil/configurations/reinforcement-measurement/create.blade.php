@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Create Reinforcement Measurement')

@section('breadcrumb-title')
    Create Reinforcement Measurement
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
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.civil.configurations.reinforcement-measurement.store', ['project' => $project]) }}" method="POST" class="custom-form">
                @include('boq.departments.civil.configurations.reinforcement-measurement.form')
                @include('components.buttons.submit-button', ['label' => 'Submit'])
            </form>
        </div>
    </div>
@endsection
