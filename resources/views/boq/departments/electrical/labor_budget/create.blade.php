@extends('boq.departments.electrical.layout.app')

@if ($formType == 'edit')
    @section('title', 'Edit Labor Budget')
@else
    @section('title', 'Create Labor Budget')
@endif
@section('breadcrumb-title')
@if ($formType == 'edit') Edit @else Create @endif EME Labor Budget
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.eme-labor-budgets.index',['project' => $project]), 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection
@section('style')
<style>

  .switch-toggle {
    display: flex;
    height: 100%;
    width: 100%;
    align-items: center;
  }
  .switch-btn, .layer {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }

  .button-check {
    position: relative;
    width: 90px;
    height: 42px;
    overflow: hidden;
    border-radius: 50px;
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    -ms-border-radius: 50px;
    -o-border-radius: 50px;
  }
  .checkbox {
    position: relative;
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 3;
  }

  .switch-btn {
    z-index: 2;
  }

  .layer {
    width: 100%;
    background-color: #8cf7a0;
    transition: 0.3s ease all;
    z-index: 1;
  }
  #button-check .switch-btn:before, #button-check .switch-btn:after {
    position: absolute;
    top: 5px;
    left: 5px;
    width: 42px;
    height: 32px;
    color: #fff;
    font-size: 9.5px;
    font-weight: bold;
    text-align: center;
    line-height: 1;
    padding: 9px 4px;
    background-color: #1bc88c;
    border-radius: 50%;
    transition: 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15) all;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'IBM Plex Sans', sans-serif;
  }

  #button-check .switch-btn:before {
    content: 'material rate';
  }

  #button-check .switch-btn:after {
    content: 'work rate';
  }

  #button-check .switch-btn:after {
    right: -50px;
    left: auto;
    background-color: #de579b;
  }

  #button-check .checkbox:checked + .switch-btn:before {
    left: -50px;
  }

  #button-check .checkbox:checked + .switch-btn:after {
    right: 4px;
  }

  #button-check .checkbox:checked ~ .layer {
    background-color: #fdd1d1;
  }
</style>
@endsection

@section('content-grid', 'col-12')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($formType == 'edit')

            <form action="{{ route('boq.project.departments.electrical.eme-labor-budgets.update',['project' => $project,'labor-budget' => $laborBudgetId]) }}" method="POST" class="custom-form">
                @method('put')
                {{-- @include('boq.departments.electrical.labor_budget.form') --}}
                @include('components.buttons.submit-button', ['label' => 'Update Budget'])
            </form>
            @else
                <form action="{{ route('boq.project.departments.electrical.eme-labor-budgets.store',['project' => $project]) }}" method="POST" class="custom-form">
                    @include('boq.departments.electrical.labor_budget.form')
                    @include('components.buttons.submit-button', ['label' => 'Create Budget'])
                </form>
            @endif

        </div>
    </div>
@endsection
