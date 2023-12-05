@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Create Material Price')

@section('breadcrumb-title')
    Create material price
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.configurations.material-price-wastage.index', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.civil.configurations.material-price-wastage.store', ['project' => $project]) }}" method="POST" class="custom-form">
                @include('boq.departments.civil.configurations.materialpricewastage.form')
                <input type="hidden" name="project_id" value="{{ $project?->id }}">
                @include('components.buttons.submit-button', ['label' => 'Submit'])
            </form>
        </div>
    </div>
@endsection
