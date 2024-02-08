@extends('layouts.backend-layout')
@section('title', 'Loan Payment')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Loan Payment
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('loan-payments.index') }}"><i class="fas fa-database"></i>
    </a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/loan-payments',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/loan-payments/$loan_payment->id",
            'method' => 'PUT',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <input type="text" class="form-control text-center" value="{{ $loanApplication->loan_type?->name }}"
                    readonly>
                <input name="loan_application_id" type="text" class="form-control text-center"
                    value="{{ $loanApplication->id }}" hidden>
                @error('loan_application_id')
                    <p class="text-danger">{{ $errors->first('loan_application_id') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Left Amount </label>
                <input type="text" class="form-control" value="{{ $loanApplication->left_amount }}" readonly>
                @error('payment_date')
                    <p class="text-danger">{{ $errors->first('payment_date') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Date <span class="text-danger">*</span></label>
                {{ Form::date('payment_date', old('payment_date') ? old('payment_date') : (!empty($loan_payment->payment_date) ? $loan_payment->payment_date : date('Y-m-d')), ['class' => 'form-control', 'id' => 'payment_date', 'required']) }}
                @error('payment_date')
                    <p class="text-danger">{{ $errors->first('payment_date') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Payment Amount <span class="text-danger">*</span></label>
                {{ Form::number(
                    'payment_amount',
                    old('payment_amount')
                        ? old('payment_amount')
                        : (!empty($loan_payment->payment_amount)
                            ? $loan_payment->payment_amount
                            : null),
                    ['class' => 'form-control', 'id' => 'payment_amount', 'placeholder' => 'Enter Payment Amount', 'required'],
                ) }}
                @error('payment_amount')
                    <p class="text-danger">{{ $errors->first('payment_amount') }}</p>
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
