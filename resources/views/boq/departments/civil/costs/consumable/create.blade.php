@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('breadcrumb-title')

@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('breadcrumb-button')
{{--    <a href="{{ route('boq.project.departments.civil.costs.consumables.index', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fa fa-database"></i></a>--}}
@endsection

@section('content')
    <style>
        #submit-button{
            width: auto;
        }
    </style>
    <form action="{{ route('boq.project.departments.civil.costs.consumables.store', ['project' => $project]) }}" method="POST" enctype="multipart/form-data" class="custom-form">
        @include('boq.departments.civil.costs.consumable.form')
        @if(isset($selectedHead))
           @include('components.buttons.submit-button', ['label' => 'Update consumable cost'])
        @else
           @include('components.buttons.submit-button', ['label' => 'Create consumable cost'])
        @endif
    </form>
@endsection
