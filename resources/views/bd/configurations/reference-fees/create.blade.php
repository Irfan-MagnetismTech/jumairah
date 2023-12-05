@extends('layouts.backend-layout')
@section('title', 'Reference of Fees')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Reference of Fees
    @else
        Add Reference of Fees
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('reference_fees.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "reference_fees/$reference_fees->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "reference_fees",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Perticular Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($reference_fees->name) ? $reference_fees->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off",'required','placeholder'=>"Perticular Name",])}}
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="amount">Amount<span class="text-danger">*</span></label>
                    {{Form::text('amount', old('amount') ? old('amount') : (!empty($reference_fees->amount) ? $reference_fees->amount : null),['class' => 'form-control','id' => 'amount', 'autocomplete'=>"off",'required','placeholder'=>"Amount",])}}
                </div>
            </div>

            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="type">Type<span class="text-danger">*</span></label>
                    {{Form::select('type', $type, old('type') ? old('type') : (!empty($reference_fees->type) ? $reference_fees->type : null),['class' => 'form-control','id' => 'type', 'placeholder'=>"Select Type", 'autocomplete'=>"off"])}}
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

