@extends('layouts.backend-layout')
@section('title', 'Employee Type')

@section('breadcrumb-title')
    {{-- @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif --}}
    Overtime Entry
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('employee-types.index') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/employee-types',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/employee-types/$employeeType->id",
            'method' => 'PUT',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
                {{ Form::date('date', old('date') ? old('date') : null, [
                    'class' => 'form-control datepicker',
                    'id' => 'date',
                    'placeholder' => 'Enter Date Here',
                    'required',
                ]) }}
                @error('date')
                    <p class="text-danger">{{ $errors->first('date') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Insertion Type <span class="text-danger">*</span></label>
                {{ Form::select('insertion_type', ['individual' => 'individual','all'=> 'all'], null, ['class' => 'form-control', 'id' => 'insertion_type']) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2 ">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('script')
    <script></script>

@endsection
