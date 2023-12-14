@extends('layouts.backend-layout')
@section('title', 'Entry')

@section('breadcrumb-title')
    Feasibility Copy
@endsection

@section('breadcrumb-button')

@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

        {!! Form::open(array('url' => "feasibility-copy",'method' => 'POST','class'=>'custom-form')) !!}

        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="location_id">Copy Form<span class="text-danger">*</span></label>
                    {{Form::select('copy_form', $oldFeasibility, old('location_id') ? old('location_id') : (!empty($fees_cost->location_id) ? $fees_cost->location_id : null),['class' => 'form-control','id' => 'location_id', 'placeholder'=>"Select Location", 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="location_id">Location<span class="text-danger">*</span></label>
                    {{Form::select('copy_to', $newFeasibility, old('location_id') ? old('location_id') : (!empty($fees_cost->location_id) ? $fees_cost->location_id : null),['class' => 'form-control','id' => 'location_id', 'placeholder'=>"Select Location", 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-xl-3 col-md-3"></div>
        </div>
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('script')

@endsection
