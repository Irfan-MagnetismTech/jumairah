@extends('layouts.backend-layout')
@section('title', 'BOQ - Edit material formula')

@section('breadcrumb-title')
    Edit Material Formula
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
