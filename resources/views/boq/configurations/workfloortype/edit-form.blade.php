@extends('layouts.backend-layout')
@section('title', 'BOQ - Edit Boq Work Floor Type')

@section('breadcrumb-title')
    Edit Boq Work Floor Type
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => 'boq.configurations.floor-type-work.index', 'type' => 'index'])
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
    <!-- Form -->
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.configurations.floor-type-work.update',['floor_type_work' => $floor_type_work]) }}" method="POST" class="custom-form">
                @method('PUT')
                @include('boq.configurations.workfloortype.form2')
                @include('components.buttons.submit-button', ['label' => 'Update'])
            </form>
        </div>
    </div>
@endsection
