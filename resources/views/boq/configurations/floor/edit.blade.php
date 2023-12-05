@extends('layouts.backend-layout')
@section('title', 'BOQ - Edit floor')

@section('breadcrumb-title')
    Edit floor
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => 'boq.configurations.floors.index', 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
<!-- Form -->
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('boq.configurations.floors.update', $floor) }}" method="POST" class="custom-form">
            @method('PUT')
            @include('boq.configurations.floor.form')
            @include('components.buttons.submit-button', ['label' => 'Update Floor'])
        </form>
    </div>
</div>
@endsection
