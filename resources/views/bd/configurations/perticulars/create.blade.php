@extends('layouts.backend-layout')
@section('title', 'BD Particular')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Particular
    @else
        Add Particular
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('feasi_perticular') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "feasi_perticular/$BdFeasi_perticular->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "feasi_perticular",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Particular Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($BdFeasi_perticular->name) ? $BdFeasi_perticular->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off",'required','placeholder'=>"Material Name",])}}
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="unit_id">Unit<span class="text-danger">*</span></label>
                    {{Form::select('unit_id', $units, old('unit_id') ? old('unit_id') : (!empty($nestedmaterial->unit_id) ? $nestedmaterial->unit_id : null),['class' => 'form-control','id' => 'unit_id', 'placeholder'=>"Select Unit", 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="type">Type<span class="text-danger">*</span></label>
                    {{Form::select('type', $type, old('type') ? old('type') : (!empty($BdFeasi_perticular->type) ? $BdFeasi_perticular->type : null),['class' => 'form-control','id' => 'type', 'placeholder'=>"Select Type", 'autocomplete'=>"off"])}}
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



    <script>

    </script>

@endsection



@section('script')
@endsection
