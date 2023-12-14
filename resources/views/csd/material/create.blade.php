@extends('layouts.backend-layout')
@section('title', 'Materials')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Material
    @else
        Add Material
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('csd/materials') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "csd/materials/$material->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "csd/materials",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <input type="hidden" name="id" value="{{@$material->id}}">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Material Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($material->name) ? $material->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="parent_id">Parent Material<span class="text-danger">*</span></label>
                    {{Form::select('parent_id', $materials, old('parent_id') ? old('parent_id') : (!empty($material->parent_id) ? $material->parent_id : null),['class' => 'form-control','id' => 'parent_id', 'placeholder'=>"Select Parent Material Name", 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="unit_id">Unit<span class="text-danger">*</span></label>
                    {{Form::select('unit_id', $units, old('unit_id') ? old('unit_id') : (!empty($material->unit_id) ? $material->unit_id : null),['class' => 'form-control','id' => 'unit_id', 'placeholder'=>"Select Unit", 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="model">Material Model</label>
                    {{Form::text('model', old('model') ? old('model') : (!empty($material->model) ? $material->model : null),['class' => 'form-control','id' => 'model', 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->
    <hr class="bg-success">
        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    {!! Form::close() !!}

@endsection
