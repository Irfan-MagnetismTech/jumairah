@extends('layouts.backend-layout')
@section('title', 'BOQ - Create floor')

@section('breadcrumb-title')
    Create floor
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => 'boq.configurations.floors.index', 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.configurations.floors.store') }}" method="POST" class="custom-form">
                @include('boq.configurations.floor.form')
                @include('components.buttons.submit-button', ['label' => 'Create floor'])
            </form>
            <a target="_blank" href="{{ route('boq.configurations.floortype.create') }}" style="font-weight: bold">Add New Type</a>
        </div>
    </div>
@endsection
