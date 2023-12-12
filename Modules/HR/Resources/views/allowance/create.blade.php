@extends('layouts.backend-layout')
@section('title', 'Allowance')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Allowance
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('allowances.index') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/allowances',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/allowances/$allowance->id",
            'method' => 'PUT',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Employee<span class="text-danger">*</span></label>
                {{ Form::select(
                    'employee_id',
                    $employees,
                    old('employee_id') ? old('employee_id') : ( !empty($allowance->employee_id) ? $allowance->employee_id : ''),
                    ['class' => 'form-control select2','required', 'id' => 'employee_id', 'placeholder' => 'Select Employee'],
                ) }}
                @error('employee_id')
                    <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Allowance Type<span class="text-danger">*</span></label>
                {{ Form::select(
                    'allowance_type_id',
                    $allowanceTypes,
                    old('allowance_type_id') ? old('allowance_type_id') : ( !empty($allowance->allowance_type_id) ? $allowance->allowance_type_id : ''),
                    ['class' => 'form-control select2', 'id' => 'allowance_type_id', 'placeholder' => 'Select Allwance Type','required'],
                ) }}
                @error('allowance_type_id')
                    <p class="text-danger">{{ $errors->first('allowance_type_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Amount<span class="text-danger">*</span></label>
                {{ Form::number(
                    'amount',
                    old('amount') ? old('amount') : ( !empty($allowance->amount) ? $allowance->amount : 0),
                    ['class' => 'form-control', 'id' => 'amount', 'placeholder' => 'Amount','required'],
                ) }}
                @error('amount')
                    <p class="text-danger">{{ $errors->first('amount') }}</p>
                @enderror
            </div>
        </div>







    </div><!-- end row -->

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2 ">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}
@endsection
@section('script')
    <script></script>

@endsection
