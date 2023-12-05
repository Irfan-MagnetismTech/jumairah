@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - Calculation')

@section('breadcrumb-title')
    Create Item Calculation
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.calculations.index',['project' => $project]), 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
    <style>
        .table thead th{
            padding: 0px 40px !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            @if ($formType == 'edit')
            
            <form action="{{ route('boq.project.departments.electrical.calculations.update',['project' => $project,'calculation' => $BoqEmeCalculationId]) }}" method="POST" class="custom-form">
                @method('put')
                @include('boq.departments.electrical.calculations.form')
                @include('components.buttons.submit-button', ['label' => 'Update Calculation'])
            </form>
            @else  
            <form action="{{ route('boq.project.departments.electrical.calculations.store',['project' => $project]) }}" method="POST" class="custom-form">
                @include('boq.departments.electrical.calculations.form')
                @include('components.buttons.submit-button', ['label' => 'Create Calculation'])
            </form>
            @endif


            
        </div>
    </div>
@endsection
