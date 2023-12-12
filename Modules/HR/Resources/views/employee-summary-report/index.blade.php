@extends('layouts.backend-layout')
@section('title', 'Attendance Summary')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Employee Summary
@endsection

@section('style')
    <style scoped>
        .input-group-addon {
            min-width: 120px;
        }

        .border-none>tr>td {
            border: none !important;
        }
    </style>
@endsection
@section('breadcrumb-button')
    {{-- <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('delivery-challans.index') }}"><i
            class="fas fa-database"></i></a> --}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-md-12 col-lg-12 col-sm-12 my-3')

@section('content')
    @if ($formType == 'employee-summary')
        {!! Form::open([
            'url' => 'hr/employee-summary/report',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">


        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_id">Employee</label>
                {{Form::select('employee_id', $employees, old('employee_id'),['class' => 'form-control select2','id' => 'employee_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
            </div>
            @error('employee_id')
                <p class="text-danger">{{ $errors->first('employee_id') }}</p>
            @enderror
        </div>

        <div id="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="year">Year <span
                        class="text-danger">*</span></label>

                <input type="number" class="form-control" name="year" id="year" placeholder="Select year here" min="1900" max="2900" value="{{ date('Y') }}" required/>

            </div>
            @error('year')
                <p class="text-danger">{{ $errors->first('year') }}</p>
            @enderror
        </div>


    </div>

    {{-- <hr class="bg-success"> --}}



    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2 ">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2" formtarget="_blank">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}
@endsection
@section('script')

@endsection
