@extends('layouts.backend-layout')
@section('title', 'BOQ - Create floor type')

@section('breadcrumb-title')
    Create floor type
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.configurations.floortype.store') }}" method="POST" class="custom-form">
                @include('boq.configurations.floortype.form')
                @include('components.buttons.submit-button', ['label' => 'Save'])
            </form>
        </div>
    </div>
@endsection
