@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Create Material Formula')

@section('breadcrumb-title')
    Create material formula
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.configurations.material-formulas.index', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            background:none !important;
            line-height: 1 !important;
        }

        .select2-container--default .select2-selection--single{
            border-radius: 0 !important;
            font-size: 13px !important;
            border: 1px solid #efefef !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.civil.configurations.material-formulas.store', ['project' => $project]) }}" method="POST" class="custom-form">
                @include('boq.departments.civil.configurations.materialformula.form')
                @include('components.buttons.submit-button', ['label' => 'Submit'])
            </form>
        </div>
    </div>
@endsection
