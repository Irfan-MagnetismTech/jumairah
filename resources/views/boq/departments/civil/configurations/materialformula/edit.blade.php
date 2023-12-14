@extends('layouts.backend-layout')
@section('title', 'BOQ - Edit material formula')

@section('breadcrumb-title')
    Edit Material Formula
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => 'boq.configurations.material-formulas.index', 'type' => 'index'])
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
        <form action="{{ route('boq.configurations.material-formulas.update', $materialFormula) }}" method="POST" class="custom-form">
            @method('PUT')
            @include('boq.configurations.materialformula.form')
            @include('components.buttons.submit-button', ['label' => 'Update Formula'])
        </form>
    </div>
</div>
@endsection
