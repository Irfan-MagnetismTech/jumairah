@extends('layouts.backend-layout')
@section('title', 'BOQ - Edit material price & wastage')

@section('breadcrumb-title')
    Edit Material Price & Wastage
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => 'boq.configurations.material-price-wastage.index', 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
<!-- Form -->
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('boq.configurations.material-price-wastage.update', $materialPriceWastage) }}" method="POST" class="custom-form">
            @method('PUT')
            @include('boq.configurations.materialpricewastage.form2')
            @include('components.buttons.submit-button', ['label' => 'Update Price'])
        </form>
    </div>
</div>
@endsection
