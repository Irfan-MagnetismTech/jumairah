@extends('layouts.backend-layout')
@section('title', 'Loan Applicaton')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Loan Hand Over Form
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('loan-applications.index') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', ' col-md-11 col-lg-12 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/loan-payment-store',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">

        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Date<span class="text-danger">*</span></label>
                {{ Form::date('date', old('date') ? old('date') : (!empty($loanApplication->date) ? $loanApplication->date : date('Y-m-d')), ['class' => 'form-control', 'id' => 'date', 'autocomplete' => 'off']) }}
            </div>
        </div>

        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon " for="loan_amount">Amount<span class="text-danger">*</span></label>
                {{ Form::number('loan_amount', old('loan_amount') ? old('loan_amount') : (!empty($loanApplication->loan_amount) ? $loanApplication->loan_amount : null), ['class' => 'form-control', 'id' => 'loan_amount', 'autocomplete' => 'off']) }}
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
