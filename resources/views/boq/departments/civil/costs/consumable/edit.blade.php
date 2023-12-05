@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('breadcrumb-title')
    Edit Consumable Cost
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.costs.consumables.index', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fa fa-database"></i></a>
@endsection

@section('content')
    <form action="{{ route('boq.project.departments.civil.costs.consumables.update', ['project' => $project, 'consumable' => $consumable]) }}" method="POST" enctype="multipart/form-data" class="custom-form">
        @method('PUT')
        @include('boq.departments.civil.costs.consumable.edit-form')
        @include('components.buttons.submit-button', ['label' => 'Update consumable cost'])
    </form>
@endsection
