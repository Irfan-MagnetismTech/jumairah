{{--@extends('layouts.backend-layout')--}}
{{--@section('title', 'BOQ - Create floor')--}}

{{--@section('breadcrumb-title')--}}
{{--    Create Boq Work Floor Type--}}
{{--@endsection--}}

{{--@section('breadcrumb-button')--}}
{{--    @include('components.buttons.breadcrumb-button', ['route' => 'boq.configurations.floor-type-work.index', 'type' => 'index'])--}}
{{--@endsection--}}

{{--@section('sub-title')--}}
{{--    <span class="text-danger">*</span> Marked are required.--}}
{{--@endsection--}}

{{--@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')--}}

{{--@section('content')--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <form action="{{ route('boq.configurations.floor-type-work.store') }}" method="POST" class="custom-form">--}}
{{--                @include('boq.configurations.workfloortype.form')--}}
{{--                @include('components.buttons.submit-button', ['label' => 'Submit'])--}}
{{--            </form>--}}
{{--            <a target="_blank" href="{{ route('boq.configurations.floortype.create') }}" style="font-weight: bold">Add New Type</a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

@extends('layouts.backend-layout')
@section('title', 'BOQ - Create Boq Work Floor Type')

@section('breadcrumb-title')
    Create Boq Work Floor Type
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
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.configurations.floor-type-work.store') }}" method="POST" class="custom-form">
                @include('boq.configurations.workfloortype.form')
                @include('components.buttons.submit-button', ['label' => 'Submit'])
            </form>
        </div>
    </div>
@endsection

