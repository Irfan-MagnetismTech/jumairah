@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Edit material price')

@section('breadcrumb-title')
    Edit Material Price
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.configurations.projectwise-material-price.index', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning">
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
            <form action="{{ route('boq.project.departments.civil.configurations.projectwise-material-price.update', ['project' => $project,'projectWiseMaterialPrice' => $projectWiseMaterialPrice]) }}" method="POST" class="custom-form">
                @method('PUT')
                @include('boq.departments.civil.configurations.projectwisematerialprice.form2')
                @include('components.buttons.submit-button', ['label' => 'Update Price'])
            </form>
        </div>
    </div>
@endsection
