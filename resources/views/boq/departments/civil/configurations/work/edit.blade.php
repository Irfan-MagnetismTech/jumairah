@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Edit work')

@section('breadcrumb-title')
    Edit work
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.configurations.works.index', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

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
        #submit-button{
            width: auto;
        }
    </style>
    <!-- Form -->
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.civil.configurations.works.update', ['project' => $project, 'work' => $work]) }}" method="POST" class="custom-form">
                @method('PUT')
                @include('boq.departments.civil.configurations.work.form')
                @include('components.buttons.submit-button', ['label' => 'Update Work'])
            </form>
        </div>
    </div>
@endsection
