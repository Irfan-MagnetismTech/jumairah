@extends('boq.layout.app')
@section('title', 'BOQ - Material Calculation List')
@section('breadcrumb-title')
    Create material specification
@endsection
@section('breadcrumb-button')
    <a href="{{ route('boq.project.material-specifications.index', ['project' => $project]) }}"
        class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection
@section('project-name')
    <a href="{{ route('boq.project.material-specifications.index', ['project' => $project]) }}"
        style="color:white;">{{ $project->name }}</a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.material-specifications.store', ['project' => $project]) }}" method="POST"
                class="custom-form">
                @include('boq.departments.civil.material-specifications.form')
                @include('components.buttons.submit-button', ['label' => 'Submit'])
            </form>
        </div>
    </div>
@endsection
