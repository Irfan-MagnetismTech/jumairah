@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - Budgets')

@section('breadcrumb-title')
    @if($formType == 'create')
    Create
    @else
    Edit
    @endif
    EME Budgets
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.budgets.index',['project' => $project]), 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if ($formType == 'edit')

            <form action="{{ route('boq.project.departments.electrical.budgets.update',['project' => $project,'budget' => 0]) }}" method="POST" class="custom-form">
                @method('put')
                @include('boq.departments.electrical.budget.form')
                @include('components.buttons.submit-button', ['label' => 'Update Budget'])
            </form>
            @else
            <form action="{{ route('boq.project.departments.electrical.budgets.store',['project' => $project]) }}" method="POST" class="custom-form">
                @include('boq.departments.electrical.budget.form')
                @include('components.buttons.submit-button', ['label' => 'Create Budget'])
            </form>
            @endif
        </div>
    </div>
@endsection
