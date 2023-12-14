@extends('layouts.backend-layout')
@section('title', 'Vehicles')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Vehicles
    @else
        Add New Vehicles
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/vehicles') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => route('vehicles.update', $vehicle->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($vehicle->id) ? $vehicle->id : null)}}">
    @else
        {!! Form::open(array('url' => route('vehicles.store'),'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="type">Vehicle Type <span class="text-danger">*</span></label>
                    {{Form::text('type', old('type') ? old('type') : (!empty($vehicle->type) ? $vehicle->type : null),['class' => 'form-control','id' => 'type', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Vehicle Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($vehicle->name) ? $vehicle->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="make">Make <span class="text-danger">*</span></label>
                    {{Form::text('make', old('make') ? old('make') : (!empty($vehicle->make) ? $vehicle->make : null),['class' => 'form-control','id' => 'make', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="model">Model<span class="text-danger">*</span></label>
                    {{Form::text('model', old('model') ? old('model') : (!empty($vehicle->model) ? $vehicle->model : null),['class' => 'form-control','id' => 'model', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="year">Year <span class="text-danger">*</span></label>
                    {{Form::text('year', old('year') ? old('year') : (!empty($vehicle->year) ? $vehicle->year : null),['class' => 'form-control','id' => 'year', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="engine">Engine <span class="text-danger">*</span></label>
                    {{Form::text('engine', old('engine') ? old('engine') : (!empty($vehicle->engine) ? $vehicle->engine : null),['class' => 'form-control','id' => 'engine', 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->
        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            $('#year').datepicker({format: "yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });//document.ready()

    </script>
@endsection
