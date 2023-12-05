@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Create Work')

@section('breadcrumb-title')
    Create work
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.configurations.works.index', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <style>
        #submit-button{
            width: auto;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.civil.configurations.works.store', ['project' => $project]) }}" method="POST" class="custom-form">
                @include('boq.departments.civil.configurations.work.form')
                @include('components.buttons.submit-button', ['label' => 'Create work'])
            </form>
            <a target="_blank" href="{{ route('units.create') }}" style="font-weight: bold">Add New Unit</a>
        </div>
    </div>
@endsection
