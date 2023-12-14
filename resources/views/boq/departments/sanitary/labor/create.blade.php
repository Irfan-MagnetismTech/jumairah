@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
    Create Labour Cost
@endsection

@section('project-name')
    {{ session()->get('project_name') }}
@endsection

@section('breadcrumb-button')
    {{--    @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.configurations.rates.index',['project' => Session::get('project_id')]), 'type' => 'index']) --}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @php($project = session()->get('project_id'))
            @if (!empty($SanitaryLaborCostData))
                {!! Form::open([
                    'url' => "boq/project/$project/departments/sanitary/labor-cost/$SanitaryLaborCostData->id",
                    'method' => 'PUT',
                    'class' => 'custom-form',
                ]) !!}
            @else
                {!! Form::open([
                    'url' => "boq/project/$project/departments/sanitary/labor-cost",
                    'method' => 'POST',
                    'class' => 'custom-form',
                ]) !!}
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="name">Item Name<span class="text-danger">*</span></label>
                        {{ Form::text('name', old('name') ? old('name') : (!empty($SanitaryLaborCostData->name) ? $SanitaryLaborCostData->name : null), ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="unit_id">Unit<span class="text-danger">*</span></label>
                        {{ Form::select('unit_id', $units, old('unit_id') ? old('unit_id') : (!empty($SanitaryLaborCostData->unit_id) ? $SanitaryLaborCostData->unit_id : null), ['class' => 'form-control', 'id' => 'unit_id', 'placeholder' => 'Select Unit', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="rate_per_unit">Rate Per Unit<span
                                class="text-danger">*</span></label>
                        {{ Form::text('rate_per_unit', old('rate_per_unit') ? old('rate_per_unit') : (!empty($SanitaryLaborCostData->rate_per_unit) ? $SanitaryLaborCostData->rate_per_unit : null), ['class' => 'form-control', 'id' => 'rate_per_unit', 'autocomplete' => 'off', 'required']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
