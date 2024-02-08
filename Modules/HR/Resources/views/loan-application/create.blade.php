@extends('layouts.backend-layout')
@section('title', 'Loan Applicaton')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Loan Applicaton
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
            'url' => 'hr/loan-applications',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/loan-applications/$loanApplication->id",
            'method' => 'PUT',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">

        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="employee_id">Employee <span class="text-danger">*</span></label>
                {{ Form::select(
                    'employee_id',
                    $employees,
                    old('employee_id') ? old('employee_id') : (!empty($loanApplication) ? $loanApplication->employee_id : null),
                    [
                        'class' => 'form-control select2',
                        'id' => 'employee_id',
                        'placeholder' => 'Select Employee',
                        'required',
                    ],
                ) }}
                @error('employee_id')
                    <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="loan_type_id">Loan Type<span class="text-danger">*</span></label>
                {{ Form::select(
                    'loan_type_id',
                    [
                        '1' => 'home loan',
                        '2' => 'car loan',
                        '3' => 'personal loan',
                        '4' => 'education loan',
                        '5' => 'gold loan',
                        '6' => 'business loan',
                        '7' => 'other loan',
                    ],
                    old('loan_type_id') ? old('loan_type_id') : (!empty($loanApplication) ? $loanApplication->loan_type_id : null),
                    [
                        'class' => 'form-control select2',
                        'id' => 'loan_type_id',
                        'placeholder' => 'Select Loan Type',
                        'required',
                    ],
                ) }}
                @error('loan_type_id')
                    <p class="text-danger">{{ $errors->first('loan_type_id') }}</p>
                @enderror
            </div>
        </div>



        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="loan_amount">Loan Amount <span class="text-danger">*</span></label>
                {{ Form::text(
                    'loan_amount',
                    old('loan_amount')
                        ? old('loan_amount')
                        : (!empty($loanApplication->loan_amount)
                            ? $loanApplication->loan_amount
                            : null),
                    [
                        'class' => 'form-control',
                        'id' => 'loan_amount',
                        'placeholder' => 'Enter loan amount Here',
                        'required',
                    ],
                ) }}
                @error('loan_amount')
                    <p class="text-danger">{{ $errors->first('loan_amount') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="loan_start_date">Loan Start Time <span
                        class="text-danger">*</span></label>
                {{ Form::date(
                    'loan_start_date',
                    old('loan_start_date')
                        ? old('loan_start_date')
                        : (!empty($loanApplication->loan_start_date)
                            ? $loanApplication->loan_start_date
                            : null),
                    [
                        'class' => 'form-control',
                        'id' => 'loan start time',
                        'placeholder' => 'Enter loan start time Here',
                        'required',
                    ],
                ) }}
                @error('loan_start_date')
                    <p class="text-danger">{{ $errors->first('loan_start_date') }}</p>
                @enderror
            </div>
        </div>


        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="loan_end_date">Loan End Time <span
                        class="text-danger">*</span></label>
                {{ Form::date(
                    'loan_end_date',
                    old('loan_end_date')
                        ? old('loan_end_date')
                        : (!empty($loanApplication->loan_end_date)
                            ? $loanApplication->loan_end_date
                            : null),
                    [
                        'class' => 'form-control',
                        'id' => 'loan_end_date',
                        'placeholder' => 'Enter loan end time Here',
                        'required',
                    ],
                ) }}
                @error('loan_end_date')
                    <p class="text-danger">{{ $errors->first('loan_end_date') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="loan_duration">Loan Duration <span
                        class="text-danger">*</span></label>
                {{ Form::text(
                    'loan_duration',
                    old('loan_duration')
                        ? old('loan_duration')
                        : (!empty($loanApplication->loan_duration)
                            ? $loanApplication->loan_duration
                            : null),
                    [
                        'class' => 'form-control',
                        'id' => 'loan_duration',
                        'placeholder' => 'Enter loan duration Here',
                        'required',
                    ],
                ) }}
                @error('loan_duration')
                    <p class="text-danger">{{ $errors->first('loan_duration') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="interest_rate">Interest Rate </label>
                {{ Form::text(
                    'interest_rate',
                    old('interest_rate')
                        ? old('interest_rate')
                        : (!empty($loanApplication->interest_rate)
                            ? $loanApplication->interest_rate
                            : null),
                    [
                        'class' => 'form-control',
                        'id' => 'interest_rate',
                        'placeholder' => 'Enter interest rate Here',
                    ],
                ) }}
                @error('interest_rate')
                    <p class="text-danger">{{ $errors->first('interest_rate') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="loan_installment">Loan Installment <span
                        class="text-danger">*</span></label>
                {{ Form::text(
                    'loan_installment',
                    old('loan_installment')
                        ? old('loan_installment')
                        : (!empty($loanApplication->loan_installment)
                            ? $loanApplication->loan_installment
                            : null),
                    [
                        'class' => 'form-control',
                        'id' => 'loan_installment',
                        'placeholder' => 'Enter loan installment Here',
                        'required',
                    ],
                ) }}
                @error('loan_installment')
                    <p class="text-danger">{{ $errors->first('loan_installment') }}</p>
                @enderror
            </div>
        </div>

        {{-- remarks  text area --}}

        <div class="col-md-4 py-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks </label>
                {{ Form::textarea(
                    'remarks',
                    old('remarks') ? old('remarks') : (!empty($loanApplication->remarks) ? $loanApplication->remarks : null),
                    [
                        'class' => 'form-control',
                        'id' => 'remarks',
                        'placeholder' => 'Enter remarks Here',
                        'rows' => 2,
                        'cols' => 10,
                    ],
                ) }}
                @error('remarks')
                    <p class="text-danger">{{ $errors->first('remarks') }}</p>
                @enderror
            </div>
        </div>


        <div class="col-12 my-2">
            <div>
                <label class="input-group" for="name">Terms and Conditions
                </label>
                <textarea name="terms_and_conditions" id="terms_and_conditions" cols="30" rows="2" class="mtl-summernote">{{ old('terms_and_conditions') ? old('terms_and_conditions') : (!empty($loanApplication->terms_and_conditions) ? $loanApplication->terms_and_conditions : null) }}</textarea>
            </div>
            @error('terms_and_conditions')
                <p class="text-danger">{{ $errors->first('terms_and_conditions') }}</p>
            @enderror
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
